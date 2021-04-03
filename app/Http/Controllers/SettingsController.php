<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function showFilerSettingsPage()
    {
        $attributes = Attribute::all();
        $filter_attributes = Attribute::select('id')
            ->where('use_for_filter',1)
            ->get();

        return view('admin.settings.filter')->with(['attributes' => $attributes, 'filter_attributes' => $filter_attributes]);
    }

    public function saveFilterSettings(Request $request)
    {
        if(count($request['attributes']) != count(array_unique($request['attributes'])))
        {
            return Redirect::back()->withErrors(['Пожалуйста, укажите 3 разных атрибута']);
        }

        if(isset($request['attributes']))
        {
            $attributes = Attribute::all();
            foreach ($attributes as $attribute) {
                $attribute->use_for_filter = 0;
                $attribute->save();
            }
            foreach ($request['attributes'] as $attribute_id) {
                if($attribute_id != 0)
                {
                    $attribute = Attribute::find($attribute_id);
                    $attribute->use_for_filter = 1;
                    $attribute->save();
                }
                else
                {
                    return Redirect::back()->withErrors(['Пожалуйста, укажите 3 разных атрибута']);
                }
            }
        }

        return redirect()->intended(route('admin.dashboard'));
    }
}
