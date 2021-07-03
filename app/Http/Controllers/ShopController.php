<?php

namespace App\Http\Controllers;

use App\Product;
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
}
