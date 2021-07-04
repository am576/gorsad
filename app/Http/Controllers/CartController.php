<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\UserNotification;
use App\UserQuery;
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

        if(isset($cart[$product_id])) {
            if(isset($cart[$product_id]['variants']))
            {
                try {
                    foreach ($cart[$product_id]['variants'] as $index => $variant) {
                        if($variant['id'] == $request->variant_id)
                        {
                            $cart[$product_id]['variants'][$index]['quantity'] += $request->quantity;

                            $cart[$product_id]['price'] += $variant['price'] * $request->quantity;

                            session()->put('cart', $cart);

                            return response($cart[$product_id], 200);
                        }
                    }
                }
                catch (\Exception $e)
                {
                    return response()->json(['cart'=>$cart]);
                }

                $variant = $product->variants()
                    ->where('id', $request->variant_id)
                    ->first();

                array_push($cart[$product_id]['variants'],
                    [
                        'id' => $variant->id,
                        'type' => $variant->type,
                        'height' => $variant->height,
                        'quantity' => $request->quantity,
                        'price' => $variant->price
                    ]
                );

                $cart[$product_id]['price'] += $variant['price'] * $request->quantity;

                session()->put('cart', $cart);

                return response($cart[$product_id], 200);
            }
        }
        else
        {
            $variant = $product->variants()
                ->where('id', $request->variant_id)
                ->first();

            if(!$cart)
            {
                $cart = [
                    $product_id => [
                        'title' => $product->title,
                        'quantity' => 1,
                        'price' => 0,
                        'image' => $product->images[0]->icon,
                        'variants' => []
                    ]
                ];

            }
            else
            {
                $cart[$product_id] = [
                    'title' => $product->title,
                    'quantity' => 1,
                    'price' => 0,
                    'image' => $product->images[0]->icon,
                    'variants' => []
                ];
            }

            array_push($cart[$product_id]['variants'],
                [
                    'id' => $variant->id,
                    'type' => $variant->type,
                    'height' => $variant->height,
                    'quantity' => $request->quantity,
                    'price' => $variant->price
                ]
            );

            $cart[$product_id]['price'] += $variant['price'] * $request->quantity;

            session()->put('cart', $cart);

            return response($cart[$product_id], 200);
        }


    }

    public function changeProductQuantity(Request $request)
    {
        $cart = session()->get('cart');
        if(isset($request->product_id) && isset($request->variant_index) && isset($request->quantity))
        {
            if(isset($cart[$request->product_id]))
            {
                $cart[$request->product_id]['variants'][$request->variant_index]['quantity'] = $request->quantity;
                $cart[$request->product_id]['price']=0;
                foreach ($cart[$request->product_id]['variants'] as $variant) {
                    $cart[$request->product_id]['price'] += ($variant['price'] * $variant['quantity']);
                }

                session()->put('cart', $cart);

                return response($request->quantity, 200);
            }
        }
    }

    public function recalculatePrices($cart)
    {

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

    public function removeProductVariant(Request $request)
    {
        if(isset($request->product_id) && isset($request->variant_index))
        {
            $cart = session()->get('cart');

            if(isset($cart[$request->product_id]))
            {
                unset($cart[$request->product_id]['variants'][$request->variant_index]);
                session()->put('cart', $cart);
                session()->flash('success', 'Product has been removed');

                return response('OK', 200);
            }
        }

        return response('Product not found', 404);
    }

    public function createQuery(Request $request)
    {

        $query_data = $request->all();

        $query = new UserQuery([
           'user_id' => auth()->user()->id,
           'status' => 'new',
           'quote_file_link' => 'some/location/file.pdf'
        ]);

        if($query->save())
        {
            foreach ($query_data['products'] as $product) {
                foreach ($product['variants'] as $variant) {
                    for ($i = 1; $i <= $variant['quantity']; $i++)
                    {
                        DB::table('queries_products')
                            ->insert([
                                'query_id' => $query->id,
                                'product_id' => $product['id'],
                                'variant_id' => $variant['id']
                            ]);
                    }
                }
            }

            $notification = new UserNotification([
                'user_id' => auth()->user()->id,
                'title' => "Ваш запрос #{$query->id} отправлен и ожидает обработки",
                'message' => "Ваш запрос {$query->id} отправлен и ожидает обработки",
                'tag' => 'info',
                'status' => 'unread'
            ]);

            $notification->save();

            return response('OK', 200);
        }

        return response('Ошибка создания предложения', 300);
    }

    public function clearCart()
    {
        session()->forget('cart');

        return response('OK',200);
    }
}
