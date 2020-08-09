<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryUpdate;
use App\Image;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $categories = Category::with('images')->get();

        return  view('admin.categories.index')->with('categories', $categories);
    }


    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'url_title' => 'required'
        ]);

        $category = new Category($request->all());
        $category->save();

        if (isset($request->images) && count($request->images)) {

            foreach ($request->images as $index => $file) {
                $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $fullname);
                $icon_path =  $file->storeAs('categories', $filename . '_icon.' . $file->getClientOriginalExtension(), 'images');
                $small_path = $file->storeAs('categories', $filename . '_small.' . $file->getClientOriginalExtension(), 'images');
                $medium_path = $file->storeAs('categories', $filename . '_medium.' . $file->getClientOriginalExtension(), 'images');
                $large_path = $file->storeAs('categories', $filename . '_large.' . $file->getClientOriginalExtension(), 'images');

                if($icon_path && $small_path && $medium_path && $large_path)
                {
                    $icon = public_path('storage/images/' . $icon_path);
                    $small = public_path('storage/images/' . $small_path);
                    $medium = public_path('storage/images/' . $medium_path);

                    $img_icon = InterventionImage::make($icon)->resize(100,100, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_small = InterventionImage::make($small)->resize(250,250, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_medium = InterventionImage::make($medium)->resize(450,450, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_icon->save($icon);
                    $img_small->save($small);
                    $img_medium->save($medium);

                    $category->images()->create([
                        'label' => $category->title . '_0' . $index,
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

    public function show($id)
    {
    }


    public function edit($id)
    {
        $category = Category::with('images')->find($id);

        return view('admin.categories.edit')->with('category', $category);
    }

    public function update(CategoryUpdate $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->fill($request->all());
        $category->save();

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

        if (isset($request->images) && count($request->images)) {

            foreach ($request->images as $index => $file) {
                $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $fullname);
                $icon_path =  $file->storeAs('categories', $filename . '_icon.' . $file->getClientOriginalExtension(), 'images');
                $small_path = $file->storeAs('categories', $filename . '_small.' . $file->getClientOriginalExtension(), 'images');
                $medium_path = $file->storeAs('categories', $filename . '_medium.' . $file->getClientOriginalExtension(), 'images');
                $large_path = $file->storeAs('categories', $filename . '_large.' . $file->getClientOriginalExtension(), 'images');

                if($icon_path && $small_path && $medium_path && $large_path)
                {
                    $icon = public_path('storage/images/' . $icon_path);
                    $small = public_path('storage/images/' . $small_path);
                    $medium = public_path('storage/images/' . $medium_path);

                    $img_icon = InterventionImage::make($icon)->resize(100,100, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_small = InterventionImage::make($small)->resize(250,250, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_medium = InterventionImage::make($medium)->resize(450,450, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_icon->save($icon);
                    $img_small->save($small);
                    $img_medium->save($medium);

                    $category->images()->create([
                        'label' => $category->title . '_0' . $index,
                        'icon' => $icon_path,
                        'small' => $small_path,
                        'medium' => $medium_path,
                        'large' => $large_path,
                        'mimetype' => $file->getClientMimeType()
                    ]);
                }
            }
        }

        return redirect()->intended(route('categories.index'));
    }


    public function destroy($id)
    {
        $category = Category::find($id);

        $products = $category->products();

        DB::table('products_attributes')
            ->whereIn('product_id', $products->pluck('id')->toArray())
            ->delete();

        $products->update(['status' => 0, 'category_id' => 0]);

        $images = $category->images()->get();

        foreach ($images as $image) {
            $images_to_delete = array_values(Image::select('icon','small','medium','large')
                ->where('id', $image->id)->get()->toArray()[0]);
            Storage::disk('images')->delete($images_to_delete);
        }

        $category->delete();

        return redirect()->intended(route('categories.index'));
    }

    private function storeImages($images)
    {

    }
}
