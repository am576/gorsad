<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryUpdate;
use App\Image;
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
            'title' => 'required'
        ]);

        $category = new Category($request->all());
        $category->save();

        if (isset($request->images) && count($request->images)) {
            foreach ($request->images as $index => $file) {
                $category->images()->create([
                    'label' => $category->title . '_0' . $index,
                    'icon' => $file->hashName(),
                    'small' => $file->hashName(),
                    'medium' => $file->hashName(),
                    'large' => $file->hashName(),
                    'mimetype' => 'lalala'
                ]);
                $file->store('categories', 'images');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
                $images = array_map(
                    function($el) {
                        return 'categories/' . $el;
                    },
                    array_values(Image::select('icon','small','medium','large')
                        ->where('id', $image_id)->get()->toArray()[0]));

                Storage::disk('images')->delete($images);
            }
            Image::whereIn('id', $request->images_to_delete)
                ->delete();
        }

        if (isset($request->images) && count($request->images)) {
            foreach ($request->images as $index => $file) {
                $category->images()->create([
                    'label' => $category->title . '_0' . $index,
                    'icon' => $file->hashName(),
                    'small' => $file->hashName(),
                    'medium' => $file->hashName(),
                    'large' => $file->hashName(),
                    'mimetype' => 'lalala'
                ]);
                $file->store('categories', 'images');
            }
        }

        return redirect()->intended(route('categories.index'));
    }


    public function destroy($id)
    {
        $category = Category::find($id);

        $products = $category->products();
        $products->update(['status' => 0]);

        $category->delete();

        return redirect()->intended(route('categories.index'));
    }

    private function storeImages($images)
    {

    }
}
