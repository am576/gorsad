<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $products = Product::all();

        return  view('admin.products.index')->with('products', $products);
    }


    public function create()
    {
        return view('admin.products.create');
    }


    public function store(Request $request)
    {
       $request->validate([
          'title' => 'required',
          'code'  =>  'required'
       ]);

       $product = new Product([
           'title' => $request->get('title'),
           'code'  => $request->get('code'),
           'description'  => $request->get('description'),
           'category_id'  => $request->get('category_id'),
           'price'  => $request->get('price'),
           'discount'  => $request->get('discount'),
           'status'  => $request->get('status')
       ]);

       $product->save();

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
        $product = Product::find($id);

        return view('admin.products.edit')->with('product', $product);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'code'  =>  'required',
            'price' =>  'digits_between:1,6'
        ]);

        Product::whereId($id)->update($request->except(['_token','_method']));

        return redirect()->intended(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
