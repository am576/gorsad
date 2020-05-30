<?php

namespace App\Http\Controllers;

use App\Attribute;
use Illuminate\Http\Request;

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
            'value' => 'required'
        ]);

        $attribute = new Attribute($request->all());
        $attribute->save();

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

        return view('admin.attributes.edit')->with(['attribute' => $attribute]);
    }


    public function update(Request $request, $id)
    {
        Attribute::whereId($id)->update($request->except(['_token','_method']));

        return redirect()->intended(route('attributes.index'));
    }


    public function destroy($id)
    {
        $attribute = Attribute::find($id);

        $attribute->delete();

        return redirect(route('attributes.index'));
    }
}
