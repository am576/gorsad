<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStore;
use App\Product;

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


    public function store(ProductStore $request)
    {
       $input = $request->input();
       foreach($input as $field=>$value)
       {
           if ($value == '')
           {
               $input[$field] = 0;
           }

       }
       $product = new Product($input);
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


    public function update(ProductStore $request, $id)
    {
        $product = Product::findOrFail($id);

        $input = $request->all();
        foreach($input as $field=>$value)
        {
            if ($value == '')
            {
                $input[$field] = 0;
            }

        }
        $product->fill($input);
        $product->save();

        return redirect()->intended(route('products.index'));
    }


    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->intended(route('products.index'));
    }
}
