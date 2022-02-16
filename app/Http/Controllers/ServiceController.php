<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Service;
use App\Utils\StaticTools;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $services = Service::paginate(5);

        return view('admin.services.index')->with('services', $services->toJson());
    }

    public function create()
    {
        $views = json_encode(config('admin.static_pages.services'));
        return view('admin.services.create', compact('views'));
    }

    public function store(ServiceRequest $request)
    {
        $input = $request->validated();

        $service = new Service();

        $service->title = $input['title'];
        $service->group_id = 0;
        $service->view = $input['view'];

        if($service->save())
        {
            StaticTools::saveImages($request->images, $service, 'service/'.$service->id);

            return redirect()->intended(route('services.index'));
        }

        return false;
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->intended(route('services.index'));
    }
}
