<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Http\Requests\ServiceOrderRequest;
use App\Image;
use App\Product;
use App\Service;
use App\ServiceOrder;
use App\Utils\StaticTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function applyFilter(Request $request)
    {
        $product_name = $request->get('product_name');
        $filter_parameters = $request->get('filter');

        $filtered_products = StaticTools::filterProducts($product_name, $filter_parameters);

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

        return 0;
    }

    public function getProductsForComparison()
    {
        if(session()->has('products_to_compare')) {
            $product_ids = session()->get('products_to_compare');
            $products = Product::whereIn('id', $product_ids)
                ->select(['id', 'title'])
                ->get();

            $products_compared = [];

            $products_compared['attributes'] = DB::table('products_attributes')
                ->join('attributes_values', 'attribute_value_id', '=', 'attributes_values.id')
                ->join('attributes', 'products_attributes.attribute_id', '=', 'attributes.id')
                ->whereIn('product_id', [1, 5])
                ->select(DB::raw('group_concat(value) as `values`'), DB::raw('group_concat(attributes_values.id) as `ids`'), 'attributes.id', 'attributes.type', 'attributes.name')
                ->groupBy('attributes.id')
                ->get();

            foreach ($products as $product) {
                $attributes = [];

                foreach ($product->savedAttributes() as $attribute) {
                    $selected_values = [];
                    $img_path = '';
                    foreach ($attribute->selected_values as $value_id) {
                        if ($attribute->type == 'icon') {
                            $img_path = Image::select('icon')
                                ->where('id',
                                    DB::table('attribute_icons')
                                        ->select('image_id')
                                        ->where('attribute_value_id', $value_id)
                                        ->pluck('image_id'))
                                ->first()->icon;
                        }
                        if ($attribute->type == 'text') {
                            array_push($selected_values, $value_id);
                        } else if ($attribute->type == 'range' || 'color') {
                            array_push($selected_values, DB::table('attributes_values')->find($value_id)->value);
                        }

                    }
                    $attributes[$attribute->id] = [
                        'type' => $attribute->type,
                        'values' => $selected_values,
                        'icon' => $img_path
                    ];

                }
                $image = $product->images()->first();
                $product['attributes'] = $attributes;
                $product['image'] = !is_null($image) ? $image['medium'] : config('product.noimage.path') . config('product.noimage.medium');
            }

            $products_compared['products'] = $products;
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
