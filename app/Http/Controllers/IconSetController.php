<?php

namespace App\Http\Controllers;

use App\IconSet;
use App\Image;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Support\Facades\Storage;

class IconSetController extends Controller
{

    public function index()
    {
        return view('admin.attributes.iconsets.index')->with('iconsets', IconSet::all());
    }


    public function create()
    {
        return view('admin.attributes.iconsets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);

        if($validated)
        {
            $input = $request->all();
            $iconset = new IconSet($input);
            $iconset->save();

            if(isset($request->images) && count($request->images)) {

                foreach ($request->images as $index => $file) {
                    $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $fullname);
                    $icon_path = $file->storeAs('attributes', $filename . '_icon.' . $file->getClientOriginalExtension(), 'images');
                    $small_path = $file->storeAs('attributes', $filename . '_small.' . $file->getClientOriginalExtension(), 'images');
                    $medium_path = $file->storeAs('attributes', $filename . '_medium.' . $file->getClientOriginalExtension(), 'images');
                    $large_path = $file->storeAs('attributes', $filename . '_large.' . $file->getClientOriginalExtension(), 'images');

                    if ($icon_path && $small_path && $medium_path && $large_path) {
                        $icon = public_path('storage/images/' . $icon_path);
                        $small = public_path('storage/images/' . $small_path);
                        $medium = public_path('storage/images/' . $medium_path);

                        $img_icon = InterventionImage::make($icon)->resize(100, 100, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img_small = InterventionImage::make($small)->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img_medium = InterventionImage::make($medium)->resize(300, 300, function ($constraint) {
                            $constraint->aspectRatio();
                        });

                        $img_icon->save($icon);
                        $img_small->save($small);
                        $img_medium->save($medium);

                        $iconset->images()->create([
                            'label' => $iconset->name . '_0' . $index,
                            'icon' => $icon_path,
                            'small' => $small_path,
                            'medium' => $medium_path,
                            'large' => $large_path,
                            'mimetype' => $file->getClientMimeType()
                        ]);
                    }
                }
            }
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $iconset = IconSet::with('images')->find($id);

        return view('admin.attributes.iconsets.edit')->with('iconset', $iconset);
    }

    public function update(Request $request, $id)
    {
       $iconset = IconSet::findOrFail($id);

       $iconset->fill($request->all());
       $iconset->save();

        if(isset($request->images_to_delete))
        {
            foreach ($request->images_to_delete as $image_id) {
                $images = array_values(Image::select('icon','small','medium','large')
                    ->where('id', $image_id)->get()->toArray()[0]);

                Storage::disk('images')->delete($images);
            }
            Image::whereIn('id', $request->images_to_delete)
                ->delete();
        }

        if(isset($request->images) && count($request->images)) {

            foreach ($request->images as $index => $file) {
                $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $fullname);
                $icon_path = $file->storeAs('attributes', $filename . '_icon.' . $file->getClientOriginalExtension(), 'images');
                $small_path = $file->storeAs('attributes', $filename . '_small.' . $file->getClientOriginalExtension(), 'images');
                $medium_path = $file->storeAs('attributes', $filename . '_medium.' . $file->getClientOriginalExtension(), 'images');
                $large_path = $file->storeAs('attributes', $filename . '_large.' . $file->getClientOriginalExtension(), 'images');

                if ($icon_path && $small_path && $medium_path && $large_path) {
                    $icon = public_path('storage/images/' . $icon_path);
                    $small = public_path('storage/images/' . $small_path);
                    $medium = public_path('storage/images/' . $medium_path);

                    $img_icon = InterventionImage::make($icon)->resize(100, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_small = InterventionImage::make($small)->resize(200, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_medium = InterventionImage::make($medium)->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_icon->save($icon);
                    $img_small->save($small);
                    $img_medium->save($medium);

                    $iconset->images()->create([
                        'label' => $iconset->name . '_0' . $index,
                        'icon' => $icon_path,
                        'small' => $small_path,
                        'medium' => $medium_path,
                        'large' => $large_path,
                        'mimetype' => $file->getClientMimeType()
                    ]);
                }
            }
        }
    }

    public function destroy($id)
    {
        $iconset = IconSet::findOrFail($id);

        $images = $iconset->images()->get();

        foreach ($images as $image) {
            $images_to_delete = array_values(Image::select('icon','small','medium','large')
                ->where('id', $image->id)->get()->toArray()[0]);
            Storage::disk('images')->delete($images_to_delete);
        }

        $iconset->delete();

        return redirect()->intended(route('icon_sets.index'));
    }
}
