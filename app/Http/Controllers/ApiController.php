<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\AttributesGroup;
use App\Category;
use App\IconSet;
use App\Image;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getCategoriesExceptSelf(Request $request)
    {
        $category = Category::find($request->id);
        $data = $category->getCategoriesExceptSelf();

        return response()->json($data);
    }

    public function getAttributesForCategory(Request $request)
    {
        $category = Category::find($request->category_id);

        return response()->json($category->attributes());
    }

    public function getCategoryParams(Request $request)
    {
        $category = Category::find($request->category_id);

        return response()->json([
            'attributes' => $category->attributes(),
            'additional_fields' => $category->additional_fields()
        ]);
    }

    public function getAttributeValues(Request $request)
    {
        $attribute = Attribute::find($request->attribute_id);
        $values = $attribute->values();

        return response()->json($values);
    }

    public function getAttributeIcons(Request $request)
    {
        $attribute = Attribute::find($request->attribute_id);
        $icons = $attribute->icons();

        $images = Image::whereIn('id', $icons->pluck('image_id'))->get();

        foreach ($images as $index => $image) {
            $image->icon_id = $icons[$index]->id;
            $image->icon_label = DB::table('attributes_values')->where('id',$icons[$index]->attribute_value_id)->get()->pluck('value')[0];
        }

        return response()->json($images);
    }

    public function getAttributesGroups()
    {
        return response()->json(AttributesGroup::all());
    }

    public function getAttributesTypes()
    {
        return response()->json(config('admin.attributes_types'));
    }

    public function getImages(Request $request)
    {
        $model = 'App\\' . $request->model;
        return $model::find($request->id)->images()->get();
    }

    public function getIconsets()
    {
        $iconsets = IconSet::with('images')->get();

        return IconSet::with('images')->get();
    }

    public function searchProducts(Request $request)
    {
        if(isset($request->q))
        {
            $products = Product::where('title', 'like', '%'.$request->q.'%')
                ->get();

            return response()->json($products);
        }

        return response()->json();
    }

    public function filterProducts(Request $request)
    {
        $params_where = [];
        if(isset($request->filter_data))
        {
            $filter_data = json_decode($request->filter_data);

            foreach ($filter_data as $filter) {
                if(isset($filter))
                {

                    $operator = 'like';
                    $value = '%'.$filter->value.'%';
                    array_push($params_where,
                        [
                            $filter->name, $operator, $value
                        ]);
                }

            }
        }

        $products = Product::where($params_where)->with('category')->orderBy('id', 'desc')->paginate($request->per_page)->toJson();

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

    public function getTable(Request $request)
    {
        return $request->entity->getTable();
    }

    public function getCart()
    {
        $cart = session()->get('cart');
        return response()->json($cart);
    }
}
