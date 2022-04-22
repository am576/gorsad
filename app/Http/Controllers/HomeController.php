<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\Image;
use App\Product;
use App\Project;
use App\ServiceGroup;
use App\User;
use App\Utils\StaticTools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $filter_parameters = json_decode($request->get('filter_options'));

        if(isset($filter_parameters))
        {
            $filtered_products = StaticTools::filterProducts($product_name, $filter_parameters);
        }
        else
        {
            $filtered_products = Product::with('image')
                ->paginate(config('shop.paginate'));
        }

        return view('frontend.shop.index')
            ->with(
                [
                    'user' => json_encode($this->getAuthUser()),
                    'products'=> json_encode($filtered_products),
                    'attributes' => json_encode(StaticTools::getAttributesByGroup()),
                    'filter_options' => json_encode($filter_parameters),
                    'filtered_name' => $product_name,
                ]
            );
    }

    public function showShopPage()
    {
        $user = $this->getAuthUser();

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
        $user = $this->getAuthUser();
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
            $icons = [];
            foreach ($attribute->selected_values as $value_id) {
                if($attribute->type == 'icon')
                {
                    $attribute_icon_id = DB::table('attribute_icons')
                        ->where('attribute_value_id', $value_id)
                        ->first()
                        ->image_id;

                    $image_path = Image::where('id',$attribute_icon_id)
                        ->first()
                        ->icon;
                    array_push($icons, $image_path);
                }

                array_push($selected_values, DB::table('attributes_values')->find($value_id)->value);
            }

            array_push($attributes,
            [
                'name' => $attribute->name,
                'type' => $attribute->type,
                'values' => $selected_values,
                'icon' => $icons
            ]);
            if($attribute->type == 'icon') unset($attributes['icon']);
        }

        $product['attributes'] = $attributes;
        $product['variants'] = $product_variants;

        return view('frontend.product-page')
            ->with('product', $product)
            ->with('cart', json_encode($cart))
            ->with('user', json_encode($user));
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

    private function getAuthUser()
    {
        $user = Auth::user();
        if(isset($user))
        {
            $companies = $user->companies()->get();
            $active_company = $user->activeCompany();
            $favorites = $user->favorites();
            $user->favorites = is_null($favorites) ? [] : $favorites;
            $user->companies = is_null($companies) ? [] : $companies;
            $user->company = is_null($active_company) ? [] : $active_company;
        }

        return $user;
    }
}
