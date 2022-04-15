<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Image;
use App\Product;
use App\Project;
use App\ServiceGroup;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('frontend.index')
            ->with(
                [
                    'categories' => $categories,
                    'auth_user' => auth()->user(),
                    'user' => $user,
                    'filter_attributes' => $filter_attributes
                ]);
    }

    public function ApplyFilter(Request $request)
    {
        $product_name = $request->get('product_name');
        $filter_options = json_decode($request->get('filter_options'));
        $filter_values = [];
        $arr = [];
        if(isset($filter_options))
        {
            $arr = (array)$filter_options;
            foreach ($filter_options as $attr_id => $attribute) {
                foreach ($attribute as $value) {
                    array_push($filter_values, $value);
                }
                if(!$arr[$attr_id])
                {
                    unset($arr[$attr_id]);
                }
            }
        }

        $attributes = (new \App\Attribute)->shopFilterAttributes();

        if(count($filter_values) == 0)
        {
            $products = Product::where('title','like', '%'.$product_name.'%')
                ->with('images')
                ->get();
        }
        else
        {
            $products = Product::where('title','like', '%'.$product_name.'%')
                ->join('products_attributes', 'products.id','=','products_attributes.product_id')
                ->select('products.*', 'products_attributes.attribute_value_id')
                ->whereIn('products_attributes.attribute_value_id',$filter_values)
                ->groupBy('products.id')
                ->with('images')
                ->get();
        }

        return view('frontend.shop.index')
            ->with(
                [
                    'products'=> $products,
                    'attributes' => $attributes,
                    'filter_options' => json_encode($arr),
                    'filtered_name' => $product_name,
                ]
            );
    }

    public function showShopPage()
    {
        $products = Product::select('*')
            ->with('images')
            ->paginate(config('shop.paginate'));

        $attributes = (new \App\Attribute)->shopFilterAttributes();

        foreach ($products as $product) {
            $product['attributes'] = $product->savedAttributes();
        }
//                return dd($products);
        return view('frontend.shop.index')
            ->with(
                [
                    'products'=> $products->toJson(),
                    'attributes' => $attributes,
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
        $cart = session()->get('cart');

        foreach ($variants_types as $type) {
            $product_variants[$type] = $product->variants()
                ->where('type', $type)
                ->get();
        }
        $attributes = [];
        foreach ($product->savedAttributes() as $attribute) {
            $selected_values = [];
            $img_path = '';
            foreach ($attribute->selected_values as $value_id) {
                if($attribute->type == 'icon')
                {
                    $img_path = Image::select('icon')
                        ->where('id', DB::table('attribute_icons')->select('image_id')->where('attribute_value_id', $value_id)->pluck('image_id'))
                        ->first()->icon;
                }
                array_push($selected_values, DB::table('attributes_values')->find($value_id)->value);
            }
            array_push($attributes,
            [
                'name' => $attribute->name,
                'type' => $attribute->type,
                'values' => $selected_values,
                'icon' => $img_path
            ]);
            if($attribute->type == 'icon') unset($attributes['icon']);
        }
        $product['attributes'] = $attributes;
        $product['variants'] = $product_variants;


        return view('frontend.product-page')
            ->with('product', $product)
            ->with('cart', json_encode($cart));
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

    public function showProjectsPage()
    {
        $projects = Project::select('id','name','coordinates')->get();

        foreach ($projects as $project) {
            $coordinates = explode(';', $project['coordinates']);
            $project['lat'] = $coordinates[0];
            $project['long'] = $coordinates[1];
            unset($project['coordinates']);
        }

        return view('frontend.projects.index', compact('projects'));
    }

    public function showProjects()
    {
        $projects = Project::select('id','name')->with('images')->get();

        return view('frontend.projects.all', compact('projects'));
    }

    public function showProjectPage($id)
    {
        return view('frontend.projects.project_page')->with('project', Project::with('images')->find($id));
    }

    public function showKnowhowPage()
    {
        return view('frontend.knowhow.index');
    }

    public function showStylesPage()
    {
        return view('frontend.styles');
    }

    public function showServicesPage()
    {
        $service_groups = ServiceGroup::with(['images'])->get();

        return view('frontend.services.index', compact('service_groups'));
    }

    public function showServicePage($id)
    {
        return view('frontend.services.service_page')->with('service_group', ServiceGroup::with(['images', 'services'])->find($id));
    }
}
