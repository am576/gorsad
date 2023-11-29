<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Category;
use App\ContactMessage;
use App\Http\Requests\ContactFormRequest;
use App\Image;
use App\Product;
use App\Project;
use App\ServiceGroup;
use App\User;
use App\Utils\StaticTools;
use Illuminate\Http\Request;
use App\Utils\User as UserUtils;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
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
        $filter_parameters =  json_decode($request->get('filter_options'));
        if(is_null($filter_parameters))
        {
            $filter_parameters = [];
        }

        if(isset($filter_parameters) || !empty($product_name))
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
                    'user' => json_encode(UserUtils:: getAuthUser()),
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
        $projects = Project::select('id','name', 'type')
            ->with('images')
            ->orderBy('type', 'asc')
            ->get()
            ->groupBy('type');

        return view('frontend.projects.index', compact('projects'));
    }

    public function showProjectTypePage($type)
    {
        $projects = Project::select('id','name','description')
            ->where('type', '=', $type)
            ->with('images')
            ->get();
        $type_name = config('projects.types.'.$type.'.name');
        return view('frontend.projects.project_type_page', compact(['projects','type','type_name']));
    }

    public function showProjectPage($id)
    {
        return view('frontend.projects.project_page')->with('project', Project::with('images:icon,small,medium,large,imageable_id')->find($id));
    }

    public function showServicesPage()
    {
        $service_groups = ServiceGroup::with(['images'])->get();

        return view('frontend.services.index', compact('service_groups'));
    }

    public function showServicePage($id)
    {
        $service_group = ServiceGroup::with(['images', 'services'])->find($id);
        $heading = $service_group->name;
        return view('frontend.services.service_page', compact('service_group', 'heading'));
    }

    public function showGuidePage(string $guide_name)
    {
        if(isset($guide_name))
        {
            $image_names = Storage::disk('images')->files('guides/'.$guide_name);

            if(count($image_names))
            {
            $image_names = json_encode(array_map(
                function ($name) {
                    return '/storage/images/' . $name;
                },
                $image_names));

                return view('frontend.guide', compact('image_names'));
            }

            return redirect('/');
        }

        return redirect('/');
    }

    public function sendMessage(ContactFormRequest $request)
    {
        $validated = $request->validated();

        $newMessage = new ContactMessage($validated);
        $newMessage->save();
    }

}
