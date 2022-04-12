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

            if($attribute->type == 'icon' && isset($request->icons))
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
            else if($attribute->type == 'range')
            {
                $this->populateRangeValues($attribute, $values);
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $attribute = Attribute::find($id);
        $icons = $attribute->icons()->pluck('image_id');

        $attribute['iconset_id'] = $attribute->iconset()->iconset_id;

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

        if($attribute->type == 'icon')
        {
            if(isset($request->icons)) {
                DB::table('attributes_values')
                    ->where('attribute_id', $attribute->id)
                    ->delete();

                DB::table('attribute_icons')
                    ->where('attribute_id', $attribute->id)
                    ->delete();

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

                return redirect()->intended(route('attributes.index'));
            }
        }
        else if($attribute->type == 'range')
        {
            DB::table('attributes_values')
                ->where('attribute_id', $attribute->id)
                ->delete();

            $this->populateRangeValues($attribute, $values);

            return redirect()->intended(route('attributes.index'));
        }
        else {
            foreach($values as $key=>$value)
            {
                DB::table('attributes_values')->updateOrInsert([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
            return redirect()->intended(route('attributes.index'));
        }
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

    private function populateRangeValues($attribute, $values)
    {
        DB::table('attributes_values')->insert([
            'attribute_id' => $attribute->id,
            'value' => $values[0]
        ]);
        DB::table('attributes_values')->insert([
            'attribute_id' => $attribute->id,
            'value' => $values[1]
        ]);
        DB::table('attributes_values')->insert([
            'attribute_id' => $attribute->id,
            'value' => $values[2]
        ]);

        if($values[2] < 1)
        {
            for ($i = $values[0]; $i <= $values[1]; $i+= $values[2])
            {
                DB::table('attributes_values')->insert([
                    'attribute_id' => $attribute->id,
                    'value' => number_format((float)$i, 1, '.', '')
                ]);
            }
        }
        else
        {
            for ($i = $values[0]; $i <= $values[1]; $i+= $values[2])
            {
                DB::table('attributes_values')->insert([
                    'attribute_id' => $attribute->id,
                    'value' => $i
                ]);
            }
        }

    }
}
