<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Http\Requests\ServiceOrderRequest;
use App\Image;
use App\Product;
use App\Service;
use App\ServiceOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function applyFilter(Request $request)
    {
        $filter = $request->get('filter');
        $product_name = $request->get('product_name');

        $filter_values = [];
        foreach ($filter as $attribute) {
            foreach ($attribute as $value) {
                array_push($filter_values, $value);
            }
        }

        $products_attrs = Product::where('title','like', '%'.$product_name.'%')
            ->join('products_attributes', 'products.id','=','products_attributes.product_id')
            ->select('products.id','attribute_value_id', 'attribute_id')
            ->whereIn('attribute_id', array_keys($filter))
            ->get()
            ->groupBy(function($item) {
                return $item->id;
            })->toArray();


        $found_products = collect($products_attrs)->mapToGroups(function($product, $key)  {
           return [$key => collect($product)->mapToGroups(function($attrs) {
               return [$attrs['attribute_id'] => $attrs['attribute_value_id']];
           })];
        })->toArray();

        $product_ids = [];
        $fails = [];

        foreach ($filter as $filter_id => $filter_vals) {
            foreach ($found_products as $id => $product) {
                if(!isset($product[0][$filter_id]) || count(array_intersect($filter_vals, $product[0][$filter_id])) == 0)
                {
                    array_push($fails, $id);
                    continue;
                }
                array_push($product_ids, $id);
            }
        }

        $result = array_diff($product_ids, $fails);

        if(count($filter_values))
        {
            $filtered_products = Product::where('title','like', '%'.$product_name.'%')->whereIn('id', $result)->with('images')->get();
            return response()->json($filtered_products);
        }
        else {
            return Product::with('images')->where('title','like', '%'.$product_name.'%')->get();
        }
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
        $products = Product::select('*')
            ->with('images')
            ->paginate(config('shop.paginate'));

        foreach ($products as $product) {
            $product['attributes'] = $product->savedAttributes();
        }

        return response()->json($products);

    }
}
