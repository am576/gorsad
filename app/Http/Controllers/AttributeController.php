<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Image;
use App\Product;
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
        $val_params = [
            'name' => 'required',

        ];
        if($request['type'] != 'bool')
        {
            $val_params['values'] = 'required|json|min:3';
        }
        $request->validate($val_params);

        $attribute = new Attribute($request->except(['values']));
        $attribute->save();

        if(isset($request->values))
        {
            $values = json_decode($request->values);

            if($attribute->type == 'range')
            {
                if($this->validateRange($values))
                {
                    $this->populateRangeValues($attribute, $values);
                }
                else
                {
                    return response()->json('error', 422);
                }
            }
            else
            {
                foreach($values as $key=>$value) {
                    $value_id = DB::table('attributes_values')->insertGetId([
                        'attribute_id' => $attribute->id,
                        'value' => $value->value,
                        'ext_value' => isset($value->ext_value) ? $value->ext_value : ''
                    ]);
                    if(isset($value->image))
                    {
                        $image = $value->image;
                        DB::table('attribute_icons')->insert([
                            'attribute_id' => $attribute->id,
                            'attribute_value_id' => $value_id,
                            'image_id' => $image->id,
                            'iconset_id' => $request->iconset_id
                        ]);
                    }
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
        $attribute['values'] = $attribute->values()->get();
        if($attribute->type == 'icon')
        {
            $attribute['iconset_id'] = $attribute->iconset();
        }

        return view('admin.attributes.edit')->with(['attribute' => $attribute]);
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);
        $input = $request->except(['values']);
        $attribute->fill($input);
        $attribute->save();

        $values = json_decode($request->values);

        if(isset($request->delete_values))
        {
            $delete_values = json_decode($request->delete_values);
            $values_in_use = Product::usedAttributeValues();
            $values_ids = [];
            foreach ($delete_values as $delete_value) {
                array_push($values_ids, $delete_value->id);
            }

            if(count(array_intersect($values_ids, $values_in_use)) == 0)
            {
                foreach ($delete_values as $delete_value) {
                    if(isset($delete_value->id))
                    {
                        DB::table('attributes_values')
                            ->where('id', $delete_value->id)
                            ->delete();
                        if(isset($delete_value->image))
                        {
                            DB::table('attribute_icons')
                                ->where('attribute_id', $delete_value->attribute_id)
                                ->where('attribute_value_id', $delete_value->id)
                                ->delete();
                        }
                    }
                }
            }
            else {
                return response()->json('Ошибка - некоторые из удалённых вами значений используются', 422);
            }
        }

        if($attribute->type == 'range')
        {
            if($this->validateRange($values))
            {
                $this->populateRangeValues($attribute, $values);
            }
            else
            {
                return response()->json('error', 422);
            }
        }
        else
        {
            foreach($values as $key=>$value)
            {
                if(isset($value->id))
                {
                    DB::table('attributes_values')
                        ->where('id',$value->id)
                        ->update([
                            'attribute_id' => $attribute->id,
                            'value' => $value->value,
                            'ext_value' => isset($value->ext_value) ? $value->ext_value : ''
                        ]);
                }
                else
                {
                    $value_id = DB::table('attributes_values')->insertGetId([
                        'attribute_id' => $attribute->id,
                        'value' => $value->value,
                        'ext_value' => isset($value->ext_value) ? $value->ext_value : ''
                    ]);
                }
                if(isset($value->image))
                {
                    $image = $value->image;

                    if(isset($value->id))
                    {
                        DB::table('attribute_icons')
                            ->where('attribute_id',$attribute->id)
                            ->where('attribute_value_id',$value->id)
                            ->update([
                                'image_id' => $image->id,
                                'iconset_id' => $request->iconset_id
                            ]);
                    }
                    else{
                        DB::table('attribute_icons')->insert([
                            'attribute_id' => $attribute->id,
                            'attribute_value_id' => $value_id,
                            'image_id' => $image->id,
                            'iconset_id' => $request->iconset_id
                        ]);
                    }
                }
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
        $range_min = $values[0]->value;
        $range_max = $values[1]->value;
        $range_step = $values[2]->value;
        $attributes_data = [
            [
                'attribute_id' => $attribute->id,
                'value' => $range_min
            ],
            [
                'attribute_id' => $attribute->id,
                'value' => $range_max
            ],
            [
                'attribute_id' => $attribute->id,
                'value' => $range_step
            ]
        ];
        DB::table('attributes_values')->insert($attributes_data);

        if($range_step < 1)
        {
            for ($i = $range_min; $i <= $range_max; $i+= $range_step)
            {
                DB::table('attributes_values')->insert([
                    'attribute_id' => $attribute->id,
                    'value' => number_format((float)$i, 1, '.', '')
                ]);
            }
        }
        else
        {
            for ($i = $range_min; $i <= $range_max; $i+= $range_step)
            {
                DB::table('attributes_values')->insert([
                    'attribute_id' => $attribute->id,
                    'value' => $i
                ]);
            }
        }
    }

    private function validateRange($values)
    {
        $MIN = 0;
        $MAX = 250;
        $range_min = $values[0]->value;
        $range_max = $values[1]->value;
        $range_step = $values[2]->value;

        if($range_min < $MIN || $range_max > $MAX || ($range_min > $range_max) || ($range_max - $range_min) < $range_step)
        {
            return false;
        }
        return true;
    }
}
