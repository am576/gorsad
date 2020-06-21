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

    public function getProducts()
    {
        $data = [
            'products' => Product::all(),
        ];
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
}
