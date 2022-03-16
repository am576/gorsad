<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceGroupRequest;
use App\ServiceGroup;
use App\Utils\StaticTools;

class ServiceGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $groups = ServiceGroup::all();

        return view('admin.services.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.services.groups.create');
    }

    public function store(ServiceGroupRequest $request)
    {
        $input = $request->validated();
        $service_group = new ServiceGroup();

        $service_group->name = $input['name'];
        $service_group->description = $input['description'];

        if($service_group->save())
        {
            StaticTools::saveImages($request->images, $service_group, 'service_groups/'.$service_group->id);

            return redirect()->intended(route('service_groups.index'));
        }

        return false;
    }
}
