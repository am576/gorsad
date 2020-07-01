<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getAllCategories()
    {
        $data = Category::all();

        return response()->json($data);
    }

    public function getChildCategories()
    {
        $data = Category::getChildrenOnly();

        return response()->json($data);
    }

    public function getAttributesForCategory(Request $request)
    {
        $attributes = Attribute::where('category_id',$request->category_id)->get();

        return response()->json($attributes);
    }

    public function getAttributeValues(Request $request)
    {
        $attribute = Attribute::find($request->attribute_id);
        $values = $attribute->values();

        return response()->json($values);
    }

    public function getProductImages(Request $request)
    {
        return Product::find($request->id)->images()->get();
    }

    public function filterProducts(Request $request)
    {
        $params_where = [];
        if(isset($request->filter_data))
        {
            $filter_data = $request->filter_data;

            foreach ($filter_data as $filter) {
                if(isset($filter))
                {
                    $filter = json_decode($filter);
                    $operator = $filter->type == 'input' ? 'like' : '=';
                    $value = $filter->type == 'input' ? '%'.$filter->value.'%'  : $filter->value;
                    array_push($params_where,
                        [
                            $filter->name, $operator, $value
                        ]);
                }

            }
        }

        $products = Product::where($params_where)->with('category')->paginate($request->per_page)->toJson();

        $jproducts = json_decode($products);

        if(!isset($jproducts->to) && !isset($jproducts->from))
        {
            $request->page = 1;
            $jproducts->from = 1;
            $jproducts->to = $jproducts->total;
            $jproducts->current_page = 1;
        }

        return json_encode($jproducts);
    }

    public function getProducts()
    {
        $products = Product::with('category')->paginate(5);

        return response()->json($products);
    }
}
