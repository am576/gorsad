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
use App\Utils\User as UserUtils;

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

        $user = UserUtils::getAuthUser();

        return view('frontend.index')
            ->with(
                [
                    'categories' => $categories,
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

    public function maintenance()
    {
        return view('frontend.maintenance');
    }

    public function showCart()
    {
        $cart = session()->get('cart');

        return view('frontend.cart')->with('cart', json_encode($cart));
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
