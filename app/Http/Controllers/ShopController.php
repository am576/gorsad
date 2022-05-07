<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Http\Requests\ServiceOrderRequest;
use App\Image;
use App\Product;
use App\Service;
use App\ServiceOrder;
use App\Utils\StaticTools;
use App\Utils\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Symfony\Component\String\indexOf;

class ShopController extends Controller
{
    public function showShopPage()
    {
        $user = User::getAuthUser();

        $products = Product::with('image')
            ->paginate(config('shop.paginate'));

        $attributes = StaticTools::getAttributesByGroup();

        return view('frontend.shop.index')
            ->with(
                [
                    'products'=> $products->toJson(),
                    'attributes' => $attributes,
                    'user' => json_encode($user)
                ]
            );
    }

    public function productPage($product_id)
    {
        $product = Product::where('id', $product_id)
            ->with(['images','reviews'])
            ->first();

        $product->variants = $product->variants()->get()->mapToGroups(function($variant) {
            return [$variant['type'] => $variant];
        })->reject(function($variant, $type) {
            return empty($type);
        })->toArray();

        $product->attributes = $product->attributes();
        $product->images = $product->images->toArray();

        $user = User::getAuthUser();

        return view('frontend.shop.product-page')
            ->with(['product'=> $product, 'user' => json_encode($user)]);
    }

    public function applyFilter(Request $request)
    {
        $product_name = $request->get('product_name');
        $filter_parameters = $request->get('filter');

        if(count($filter_parameters) > 0 || !empty($product_name))
        {
            $filtered_products = StaticTools::filterProducts($product_name, $filter_parameters);
        }
        else
        {
            $filtered_products = Product::with('image')
                ->paginate(config('shop.paginate'));
        }

        return response()->json($filtered_products);
    }

    public function addProductsToCompare(Request $request)
    {
        if(isset($request->products))
        {
            $ids = $request->products;
            if(session()->has('products_to_compare'))
            {
                session()->forget('products_to_compare');
            }
            session()->put('products_to_compare', $ids);

            return session()->get('products_to_compare');
        }
    }

    public function removeFromCompare(Request $request)
    {
        if(isset($request->product_id) && session()->has('products_to_compare')) {
            $products = session()->get('products_to_compare');
            if(in_array($request->product_id, $products))
            {
                array_splice($products, array_search($request->product_id, $products), 1);

                session()->put('products_to_compare', $products);
            }
        }
    }

    public function getProductsForComparison()
    {
        if(session()->has('products_to_compare')) {
            $product_ids = session()->get('products_to_compare');

            $products = Product::whereIn('id', $product_ids)
                ->with('image')
                ->select(['id', 'title'])
                ->get();

            foreach ($products as $product) {
                $product['attributes'] = collect($product->attributes())->mapWithKeys(function($attribute) {
                    return [$attribute['id'] => $attribute];
                });
            }

            $products_compared['products'] = $products;
            $products_compared['attributes'] = DB::table('products_attributes')
                ->join('attributes_values', 'attribute_value_id', '=', 'attributes_values.id')
                ->join('attributes', 'products_attributes.attribute_id', '=', 'attributes.id')
                ->whereIn('product_id', $product_ids)
                ->select(DB::raw('group_concat(value) as `values`'), DB::raw('group_concat(attributes_values.id) as `ids`'), 'attributes.id', 'attributes.type', 'attributes.name')
                ->groupBy('attributes.id')
                ->get();

            return $products_compared;
        }
    }

    public function createOrderService($service_id, ServiceOrderRequest $request)
    {
        $service = Service::findOrFail($service_id);
        $input = $request->validated();

        $service_order = new ServiceOrder($input);
        $service_order['service_id'] = $service_id;

        if($service_order->save())
        {
            $data = ['message' => 'OK!'];

            return response()->json($data, 200);
        }

        return response()->json('error', 422);
    }

    public function loadProducts()
    {
        $products = Product::with('image')
            ->paginate(config('shop.paginate'));

        return response()->json($products);
    }
}
