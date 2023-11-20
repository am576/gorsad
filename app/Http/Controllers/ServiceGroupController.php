<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceGroupRequest;
use App\Image;
use App\ServiceGroup;
use App\Utils\ImageUtils;
use App\Utils\StaticTools;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\ImageException;

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
            if(isset($request->main_image))
            {
                try
                {
                    $service_group->image = ImageUtils::saveOriginalImage($request->main_image, $service_group, "service_groups/$service_group->id/");
                    $service_group->save();
                }
                catch (ImageException $e)
                {
                    return response()->json($e);
                }

            }
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

            if(isset($request->main_image))
            {
                if($request->main_image == 'delete')
                {
                    StaticTools::deleteEntityImage($service_group);
                    return 1;
                }
                else {
                    try
                    {
                        $service_group->image = ImageUtils::saveOriginalImage($request->main_image, $service_group, "service_groups/$service_group->id/");
                        $service_group->save();
                    }
                    catch (ImageException $e)
                    {
                        return response()->json($e);
                    }
                }
            }
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
