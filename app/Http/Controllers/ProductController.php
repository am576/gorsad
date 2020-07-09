<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;
use App\Image;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $products = Product::with('category')->get();

        return  view('admin.products.index')->with('products', $products);
    }


    public function create()
    {
        return view('admin.products.create');
    }


    public function store(ProductStore $request)
    {
        $input = $request->except(['attribute_id', 'attribute_value_id']);
        foreach ($input as $field => $value) {
            if ($value == '') {
                $input[$field] = 0;
            }
        }

        $product = new Product($input);
        $product->save();

        if (isset($request->images) && count($request->images)) {
            foreach ($request->images as $index => $file) {
                $product->images()->create([
                    'label' => $product->title . '_0' . $index,
                    'icon' => $file->hashName(),
                    'small' => $file->hashName(),
                    'medium' => $file->hashName(),
                    'large' => $file->hashName(),
                    'mimetype' => 'lalala'
                ]);
                $file->store('products', 'images');
            }
        }

        if (isset($request->attribute_id) && count($request->attribute_id)) {
            foreach ($request->attribute_id as $index => $id) {
                DB::table('products_attributes')->insert([
                    'product_id' => $product->id,
                    'attribute_id' => $id,
                    'attribute_value_id' => $request->attribute_value_id[$index]
                ]);
            }
        }

        return redirect()->intended(route('products.index'));
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
        $product = Product::with('images')->find($id);

        return view('admin.products.edit')->with('product', $product);
    }


    public function update(ProductUpdate $request, $id)
    {
        $product = Product::findOrFail($id);

        $input = $request->except(['attribute_id', 'attribute_value_id']);
        foreach ($input as $field => $value) {
            if ($value == '') {
                $input[$field] = 0;
            }
        }

        $product->fill($input);
        $product->save();


        if (isset($request->images) && count($request->images))
        {
            foreach ($request->images as $index => $file)
            {
                $product->images()->create([
                    'label' => $product->title . '_0' . $index,
                    'icon' => $file->hashName(),
                    'small' => $file->hashName(),
                    'medium' => $file->hashName(),
                    'large' => $file->hashName(),
                    'mimetype' => 'lalala'
                ]);
                $file->store('products', 'images');
            }
        }

        if (isset($request->attribute_id) && count($request->attribute_id))
        {
            foreach ($request->attribute_id as $index => $id)
            {
                DB::table('products_attributes')->updateOrInsert([
                    'product_id' => $product->id,
                    'attribute_id' => $id,
                    'attribute_value_id' => $request->attribute_value_id[$index]
                ], [
                    'product_id' => $product->id,
                    'attribute_id' => $id,
                    'attribute_value_id' => $request->attribute_value_id[$index]
                ]);
            }
        }

        if(isset($request->attributes_to_delete))
        {
            foreach ($request->attributes_to_delete as $attr_id)
            {
                DB::table('products_attributes')
                    ->where([
                        ['product_id','=', $product->id],
                        ['attribute_id','=', $attr_id]
                    ])
                    ->delete();
            }
        }

        if(isset($request->images_to_delete))
        {
            foreach ($request->images_to_delete as $image_id) {
                $images = array_map(
                    function($el) {
                      return 'products/' . $el;
                    },
                    array_values(Image::select('icon','small','medium','large')
                    ->where('id', $image_id)->get()->toArray()[0]));

                Storage::disk('images')->delete($images);
            }
            Image::whereIn('id', $request->images_to_delete)
                ->delete();
        }

        return redirect()->intended(route('products.index'));
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        DB::table('products_attributes')->where('product_id', $id)->delete();

        $product->delete();

        return redirect()->intended(route('products.index'));
    }
}
