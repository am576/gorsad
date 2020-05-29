<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryUpdate;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::all();

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

        return redirect(route('categories.index'));

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
        $category = Category::find($id);

        return view('admin.categories.edit')->with('category', $category);
    }

    public function update(CategoryUpdate $request, $id)
    {
        Category::whereId($id)->update($request->except(['_token','_method']));

        return redirect()->intended(route('categories.index'));
    }


    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->intended(route('categories.index'));
    }
}
