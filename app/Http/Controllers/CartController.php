<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Product;
use App\Rules\ValidProducts;
use App\UserNotification;
use App\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addProduct(AddProductRequest $request)
    {
        $validated = $request->validated();

        $product_id = $validated['product_id'];
        $variant_id = $validated['variant_id'];
        $quantity = $validated['quantity'];

        $product = Product::find($product_id);

        $cart = session()->get('cart');

        if(!isset($cart[$product_id]))
        {
            $cart[$product_id] = [
                'title' => $product->title,
                'image' => isset($product->images[0]) ? $product->images[0]->icon : config('product.noimage.path') . config('product.noimage.icon'),
                'variants' => [],
                'price' => 0
            ];
        }
        if(isset($cart[$product_id]['variants'][$variant_id]))
        {
            $quantity += $cart[$product_id]['variants'][$variant_id]['quantity'];
        }

        $variant = $product->variants()
            ->where('id', $variant_id)
            ->first();

        $cart[$product_id]['variants'][$variant_id] = [
                'id' => $variant->id,
                'type' => $variant->type,
                'height' => $variant->height,
                'width' => $variant->width,
                'quantity' => $quantity,
                'price' => $variant->price,
                'bonus' => $variant->bonus_value
            ];

        session()->put('cart', $cart);

        return response($cart[$product_id], 200);
    }

    public function changeProductQuantity(AddProductRequest $request)
    {
        $validated = $request->validated();

        $product_id = $validated['product_id'];
        $variant_id = $validated['variant_id'];
        $quantity = $validated['quantity'];

        $cart = session()->get('cart');
        if(isset($cart[$product_id]['variants'][$variant_id]))
        {
            $cart[$product_id]['variants'][$variant_id]['quantity'] = $quantity;

            session()->put('cart', $cart);

            return response($quantity, 200);
        }
    }

    public function useBonuses(Request $request)
    {
        if(isset($request->amount))
        {
            $order_bonuses_spent = $request->amount;

            if(is_numeric($order_bonuses_spent))
            {
                if(auth()->user()->bonusesTotal() >= $order_bonuses_spent)
                {
                    session()->put('bonuses' , $order_bonuses_spent);
                    return response()->json([
                        'status' => 'success',
                        'msg' => 'OK'
                    ], 200);
                }
                else
                {
                    return response()->json([
                        'status' => 'error',
                        'msg' => 'Not enough bonuses'
                    ], 422);
                }

            }
        }
    }

    public function getTotalPrice()
    {
        $cart = session()->get('cart');
        $price_total = 0;

        if(isset($cart))
        {
            foreach ($cart as $product) {
                foreach ($product['variants'] as $variant)
                {
                    $price_total += $variant['price'] * $variant['quantity'];
                }
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

        return response('Not found', 422);
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

        return response('Product not found', 422);
    }

    public function createQuery(Request $request)
    {
        $validated = $request->validate([
            'products' => ['required', new ValidProducts]
        ]);
        $products = $validated['products'];
        $bonuses = session()->get('bonuses');
        $user_id = auth()->user()->id;

        $query = new UserQuery([
            'user_id' => $user_id,
            'status' => 'new',
            'quote_file_link' => 'some/location/file.pdf',
            'bonuses' => isset($bonuses) ? $bonuses : 0
        ]);

        if($query->save()) {
            foreach ($products as $product) {
                foreach ($product['variants'] as $variant) {
                    for ($i = 1; $i <= $variant['quantity']; $i++) {
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
                'user_id' => $user_id,
                'title' => "Ваш запрос #{$query->id} отправлен и ожидает обработки",
                'message' => "Ваш запрос #{$query->id} отправлен и ожидает обработки",
                'tag' => 'info',
                'status' => 'unread'
            ]);

            $notification->save();

            return response('OK', 200);
        }

        return response('Error', 422);
    }

    public function clearCart()
    {
        session()->forget('cart');

        return response('OK',200);
    }
}
