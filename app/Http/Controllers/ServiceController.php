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
        return view('admin.services.create');
    }

    public function store(ServiceRequest $request)
    {
        $input = $request->validated();

        $service = new Service();

        $service->name = $input['name'];
        $service->group_id = $input['group_id'];
        $service->description = $input['description'];
        $service->price = $input['price'];

        if($service->save())
        {
            return redirect()->intended(route('services.index'));
        }

        return false;
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    public function update(ServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $validated = $request->validated();

        $service->fill([
           'name' => $validated['name'],
           'group_id' => $validated['group_id'],
           'description' => $validated['description'],
           'price' => $validated['price']
        ]);

        if($service->save())
        {
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
