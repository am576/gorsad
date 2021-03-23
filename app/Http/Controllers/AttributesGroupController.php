<?php

namespace App\Http\Controllers;

use App\AttributesGroup;
use Illuminate\Http\Request;

class AttributesGroupController extends Controller
{
    public function index()
    {
        return view('admin.attributes.groups.index')->with('groups', AttributesGroup::all());
    }


    public function create()
    {
        return view('admin.attributes.groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required'
        ]);

        if($validated)
        {
            $group = new AttributesGroup($request->all());
            $group->save();

            return redirect(route('attributes_groups.index'));
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
        $group = AttributesGroup::find($id);

        return view('admin.attributes.groups.edit', ['group' => $group]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required'
        ]);

        if($validated)
        {
            $attribute = AttributesGroup::findOrFail($id);

            $input = $request->all();
            $attribute->fill($input);
            $attribute->save();

            return redirect(route('attributes_groups.index'));
        }
    }

    public function destroy($id)
    {
        $group = AttributesGroup::findOrFail($id);
        $group->delete();

        return redirect(route('attributes_groups.index'));
    }
}
