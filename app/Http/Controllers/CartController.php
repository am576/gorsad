<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($request->product_id);

        if(!$product)
        {
            abort(404);
        }

        $cart = session()->get('cart');

        if(!$cart)
        {
            $cart = [
                $product_id => [
                    'title' => $product->title,
                    'quantity' => 0,
                    'price' => $product->price,
                    'image' => $product->images[0]->icon
                ]
            ];
        }
        else
        {
            $cart[$product_id] = [
                'title' => $product->title,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->images[0]->icon

            ];
        }

        if(isset($cart[$product_id])) {

            try {
                $cart[$product_id]['quantity']++;

                session()->put('cart', $cart);

                return response('OK', 200);
            }
            catch (\Exception $e)
            {
                return response()->json(['cart'=>$cart]);
            }

        }

        session()->put('cart', $cart);

        return response('OK', 200);
    }

    public function getTotalPrice()
    {
        $price_total = 0;
        $cart = session()->get('cart');
        if(isset($cart))
        {
            foreach ($cart as $product) {
                $price_total += $product['price'] * $product['quantity'];
            }
        }

        return response($price_total,'200');
    }

    public function removeProduct(Request $request)
    {
        if($request->id)
        {
            $cart = session()->get('cart');
            if(isset($cart[$request->id]))
            {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }

            session()->flash('success', 'Product has been removed');
            return response('OK', 200);
        }

        return response('Not found', 404);
    }

    public function doCheckout(Request $request)
    {
        $order_data = $request->all();

        $order = new Order([
           'client_name' => $order_data['client']['name'],
           'client_phone' => $order_data['client']['phone'],
           'sum_total' => $order_data['sum_total']
        ]);

        if($order->save())
        {
            foreach ($order_data['products'] as $product_id) {
                DB::table('orders_products')
                    ->insert([
                        'order_id' => $order->id,
                        'product_id' => $product_id
                    ]);
            }

            return response('OK', 200);
        }

        return response('Unexpected error', 300);
    }

    public function clearCart()
    {
        session()->forget('cart');

        return response('OK',200);
    }

}
