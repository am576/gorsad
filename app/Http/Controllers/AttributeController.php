<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.attributes.index')->with('attributes', Attribute::all());
    }


    public function create()
    {
        return view('admin.attributes.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $attribute = new Attribute($request->except(['values']));
        $attribute->save();

        if(isset($request->values))
        {
            $values = explode(',', $request->values);

            if(isset($request->icons))
            {
                $icons = explode(',', $request->icons);
                foreach($values as $key=>$value)
                {
                    $value_id = DB::table('attributes_values')->insertGetId([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                    ]);

                    DB::table('attribute_icons')->insert([
                       'attribute_id' => $attribute->id,
                       'attribute_value_id' => $value_id,
                       'image_id' => $icons[$key],
                       'iconset_id' => $request->iconset_id
                    ]);
                }
            }
            else {
                foreach($values as $key=>$value)
                {
                    $value_id = DB::table('attributes_values')->insert([
                        'attribute_id' => $attribute->id,
                        'value' => $value
                    ]);
                }
            }

        }



        return redirect(route('attributes.index'));
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
        $attribute = Attribute::find($id);
        $icons = $attribute->icons()->pluck('image_id');

        $images = Image::whereIn('id', $icons)->get();
        return view('admin.attributes.edit')->with([
            'attribute' => $attribute,
            'images' => $images
        ]);
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $input = $request->except(['values']);
        $attribute->fill($input);
        $attribute->save();

        $values = explode(',', $request->values);

        DB::table('attributes_values')
            ->where('attribute_id', $attribute->id)
            ->delete();

        DB::table('attribute_icons')
            ->where('attribute_id', $attribute->id)
            ->delete();

        if(isset($request->icons)) {
            $icons = explode(',', $request->icons);

            foreach ($values as $key => $value) {
                $value_id = DB::table('attributes_values')->insertGetId([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);

                DB::table('attribute_icons')->insert([
                    'attribute_id' => $attribute->id,
                    'attribute_value_id' => $value_id,
                    'image_id' => $icons[$key],
                    'iconset_id' => $request->iconset_id
                ]);
            }
        }
        else {
            foreach($values as $key=>$value)
            {
                DB::table('attributes_values')->insert([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
        }

        return redirect()->intended(route('attributes.index'));
    }

    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        DB::table('attributes_values')
            ->where('attribute_id', $attribute->id)
            ->delete();

        $attribute->delete();

        return redirect(route('attributes.index'));
    }
}
