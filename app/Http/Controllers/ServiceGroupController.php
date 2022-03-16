<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceGroupRequest;
use App\Image;
use App\ServiceGroup;
use App\Utils\StaticTools;
use Illuminate\Support\Facades\Storage;

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

    public function edit($id)
    {
        $service_group = ServiceGroup::with(['images'])->findOrFail($id);

        return view('admin.services.groups.edit', compact('service_group'));
    }

    public function update(ServiceGroupRequest $request, $id)
    {
        $service_group = ServiceGroup::findOrFail($id);

        $validated = $request->validated();

        $service_group->fill([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        if($service_group->save())
        {
            if(isset($request->images_to_delete))
            {
                StaticTools::deleteImages($request->images_to_delete);
            }

            StaticTools::saveImages($request->images, $service_group, 'service_groups/'.$service_group->id);
        }
    }

    public function destroy($id)
    {
        $service_group = ServiceGroup::findOrFail($id);

        foreach ($service_group->images()->pluck('id') as $image_id) {
            $images = array_values(Image::select('icon','small','medium','large')
                ->where('id', $image_id)->get()->toArray()[0]);

            Storage::disk('images')->delete($images);
        }

        $service_group->images()->delete();
        $service_group->delete();
    }
}
