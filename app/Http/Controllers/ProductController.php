<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;
use App\Image;
use App\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as InterventionImage;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->with('category')->get();

        return  view('admin.products.index')->with('products', $products);
    }


    public function create()
    {
        return view('admin.products.create');
    }


    public function store(ProductStore $request)
    {
        $input = $request->except(['attribute_id', 'attribute_value_id', 'attributes', 'variants']);
        foreach ($input as $field => $value) {
            if ($value == '') {
                $input[$field] = 0;
            }
        }

        $product = new Product($input);
        $product->save();

        if(isset($request->variants))
        {
            $variants = json_decode($request->get('variants'));
            foreach ($variants as $variant) {
                DB::table('product_variants')->insert(
                    [
                        'product_id' => $product->id,
                        'type' => $variant->type,
                        'height' => implode(',',$variant->height),
                        'width' => implode(',',$variant->width),
                        'price' => $variant->price,
                        'bonus_price' => $variant->bonus_price,
                        'bonus_value' => $variant->bonus_value,
                        "created_at" =>  Carbon::now(),
                        "updated_at" =>  Carbon::now(),
                    ]
                );
            }
        }

        if(isset($request->images))
        {
            foreach ($request->images as $index => $file) {
                $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $fullname);
                $icon_path =  $file->storeAs('products', $filename . '_icon.' . $file->getClientOriginalExtension(), 'images');
                $small_path = $file->storeAs('products', $filename . '_small.' . $file->getClientOriginalExtension(), 'images');
                $medium_path = $file->storeAs('products', $filename . '_medium.' . $file->getClientOriginalExtension(), 'images');
                $large_path = $file->storeAs('products', $filename . '_large.' . $file->getClientOriginalExtension(), 'images');

                if($icon_path && $small_path && $medium_path && $large_path)
                {
                    $icon = public_path('storage/images/' . $icon_path);
                    $small = public_path('storage/images/' . $small_path);
                    $medium = public_path('storage/images/' . $medium_path);

                    $img_icon = InterventionImage::make($icon)->resize(100,100, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_small = InterventionImage::make($small)->resize(200,200, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_medium = InterventionImage::make($medium)->resize(300,300, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_icon->save($icon);
                    $img_small->save($small);
                    $img_medium->save($medium);

                    $product->images()->create([
                        'label' => $product->title . '_0' . $index,
                        'icon' => $icon_path,
                        'small' => $small_path,
                        'medium' => $medium_path,
                        'large' => $large_path,
                        'mimetype' => $file->getClientMimeType()
                    ]);
                }
            }
        }
        if(isset($request->attributes))
        {

            $attributes = json_decode($request->get('attributes'));
            $ids = [];

            foreach ($attributes as $attribute)
            {
                if(!in_array($attribute->id,$ids))
                {
                    array_push($ids, $attribute->id);
                    foreach ($attribute->values as $attribute_value)
                    {
                        DB::table('products_attributes')->insert([
                            'product_id' => $product->id,
                            'attribute_id' => $attribute->id,
                            'attribute_value_id' => $attribute_value
                        ]);
                    }
                }
            }
        }
        return redirect()->intended(route('products.index'));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $product = Product::with(['images','variants'])->find($id);

        return view('admin.products.edit')->with('product', $product);
    }


    public function update(ProductUpdate $request, $id)
    {
        $product = Product::findOrFail($id);

        $input = $request->except(['attribute_id', 'attribute_value_id', 'attributes']);
        foreach ($input as $field => $value) {
            if ($value == '') {
                $input[$field] = 0;
            }
        }

        $product->fill($input);
        $product->save();

        if(isset($request->images))
        {
            foreach ($request->images as $index => $file) {
                $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $fullname);
                $icon_path =  $file->storeAs('products', $filename . '_icon.' . $file->getClientOriginalExtension(), 'images');
                $small_path = $file->storeAs('products', $filename . '_small.' . $file->getClientOriginalExtension(), 'images');
                $medium_path = $file->storeAs('products', $filename . '_medium.' . $file->getClientOriginalExtension(), 'images');
                $large_path = $file->storeAs('products', $filename . '_large.' . $file->getClientOriginalExtension(), 'images');

                if($icon_path && $small_path && $medium_path && $large_path)
                {
                    $icon = public_path('storage/images/' . $icon_path);
                    $small = public_path('storage/images/' . $small_path);
                    $medium = public_path('storage/images/' . $medium_path);

                    $img_icon = InterventionImage::make($icon)->resize(100,100, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_small = InterventionImage::make($small)->resize(200,200, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_medium = InterventionImage::make($medium)->resize(300,300, function($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img_icon->save($icon);
                    $img_small->save($small);
                    $img_medium->save($medium);

                    $product->images()->create([
                        'label' => $product->title . '_0' . $index,
                        'icon' => $icon_path,
                        'small' => $small_path,
                        'medium' => $medium_path,
                        'large' => $large_path,
                        'mimetype' => $file->getClientMimeType()
                    ]);
                }
            }
        }

        DB::table('product_variants')
            ->where('product_id', $product->id)
            ->delete();

        if(isset($request->variants))
        {
            $variants = json_decode($request->get('variants'));
            foreach ($variants as $variant) {
                DB::table('product_variants')->insert(
                    [
                        'product_id' => $product->id,
                        'type' => $variant->type,
                        'height' => implode(',',$variant->height),
                        'width' => implode(',',$variant->width),
                        'price' => $variant->price,
                        'bonus_price' => $variant->bonus_price,
                        'bonus_value' => $variant->bonus_value,
                        "created_at" =>  Carbon::now(),
                        "updated_at" =>  Carbon::now(),
                    ]
                );
            }
        }

        if(isset($request->attributes))
        {
            $attributes = json_decode($request->get('attributes'));
            foreach ($attributes as $attribute)
            {
                if(!is_null($attribute))
                {
                    DB::table('products_attributes')
                        ->where('attribute_id','=', $attribute->id)
                        ->where('product_id','=', $id)
                        ->delete();
                    foreach ($attribute->values as $attribute_value)
                    {
                        DB::table('products_attributes')->insert([
                            'product_id' => $product->id,
                            'attribute_id' => $attribute->id,
                            'attribute_value_id' => $attribute_value
                        ]);
                    }
                }
            }
        }

        if(isset($request->attributes_to_delete))
        {
            foreach ($request->attributes_to_delete as $attr_id)
            {
                DB::table('products_attributes')
                    ->where('attribute_id', $attr_id)
                    ->delete();
            }
        }

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
