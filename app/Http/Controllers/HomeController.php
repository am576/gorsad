<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function index()
    {
        $root_category = Category::where('url_title', '')->first();
        $categories = $root_category->getChildrenCategories();
        $filter_attributes = Attribute::smallFilterAttributes();

        return view('frontend/index')
            ->with('categories', $categories)
            ->with('auth_user',  auth()->user())
            ->with('filter_attributes',$filter_attributes);
    }

    public function ApplyFilter(Request $request)
    {

        $product_name = $request->get('product_name');
        $filter_options = json_decode($request->get('filter_options'));
        $filter_values = [];

        foreach ($filter_options as $attribute) {
            foreach ($attribute as $value) {
                array_push($filter_values, $value);
            }
        }

        if(count($filter_values) == 0)
        {
            $products = Product::where('title','like', '%'.$product_name.'%')->get();

            return view('frontend.shop.index')->with('products', $products);
        }

        $products = Product::where('title','like', '%'.$product_name.'%')
            ->join('products_attributes', 'products.id','=','products_attributes.product_id')
            ->select('products.*', 'products_attributes.attribute_value_id')
            ->whereIn('products_attributes.attribute_value_id',$filter_values)
            ->groupBy('products.id')
            ->get();

        return view('frontend.shop.index')->with('products', $products);
    }

    public function showShopPage()
    {
        $products = Product::all();

        return view('frontend.shop.index')->with('products', $products);
    }

    public function maintenance()
    {
        return view('frontend.maintenance');
    }

    public function categoryPage($url_title)
    {
        $view_data = [];
        $category = Category::where('url_title', $url_title)->first();
        $child_categories = $category->getChildrenCategories();
        $products = $category->products()->with('images')->get();

        $view_data['category'] = (object)$category;

        if(!$child_categories->isEmpty())
        {
            $view_data['child_categories'] = $child_categories;
        }

        if(!$products->isEmpty())
        {
            $view_data['products'] = $products;
        }

        return view('frontend.category-page', $view_data);
    }

    public function productPage($product_code)
    {
        $product = Product::where('code', $product_code)
            ->with('images')
            ->first();

        return view('frontend.product-page')->with('product', $product);
    }

    public function showCart()
    {
        $cart = session()->get('cart');

        return view('frontend.cart')->with('cart',json_encode($cart));
    }

    public function showCheckoutPage()
    {
        $order_products = session()->get('cart');

        return view('frontend.checkout')->with('order_products',json_encode($order_products));
    }
}
