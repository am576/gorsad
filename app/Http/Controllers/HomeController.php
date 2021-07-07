<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Product;
use App\User;
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
        $root_category = Category::where('url_title', 'root')->first();
        $categories = Category::all();
        $filter_attributes = Attribute::smallFilterAttributes();

        $user = auth()->user();
        if(isset($user))
        {
            $user = User::where('id',auth()->user()->id)->with(['user_notifications', 'companies'])->first();
            $user->favorites = $user->favorites();

        }

        return view('frontend/index')
            ->with('categories', $categories)
            ->with('auth_user',  auth()->user())
            ->with('user', $user)
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
            $products = Product::where('title','like', '%'.$product_name.'%')
                ->with('images')
                ->get();

            return view('frontend.shop.index')->with('products', $products);
        }

        $products = Product::where('title','like', '%'.$product_name.'%')
            ->join('products_attributes', 'products.id','=','products_attributes.product_id')
            ->select('products.*', 'products_attributes.attribute_value_id')
            ->whereIn('products_attributes.attribute_value_id',$filter_values)
            ->groupBy('products.id')
            ->with('images')
            ->get();

        return view('frontend.shop.index')->with('products', $products);
    }

    public function showShopPage()
    {
        $products = Product::select('*')
            ->with('images')
            ->get();

        $attributes = (new \App\Attribute)->shopFilterAttributes();

        return view('frontend.shop.index')
            ->with(
                [
                    'products'=> $products,
                    'attributes' => $attributes
                ]
            );
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

    public function productPage($product_id)
    {
        $product = Product::where('id', $product_id)
            ->with('images')
            ->with('reviews')
            ->first();

        $variants_types = ['st','mtst','sol'];

        foreach ($variants_types as $type) {
            $product_variants[$type] = $product->variants()
                ->where('type', $type)
                ->get();
        }

        $product['variants'] = $product_variants;

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

        return view('frontend.checkout')->with('order_products', json_encode($order_products));
    }
}
