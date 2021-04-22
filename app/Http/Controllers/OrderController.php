<?php

namespace App\Http\Controllers;

use App\Order;
use App\UserNotification;
use App\UserQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $queries = UserQuery::all();
        $orders = Order::all();

        return view('admin.orders.index')
            ->with([
                'queries' => $queries,
                'orders' => $orders
            ]);
    }

    public function showUserQuery($id)
    {
        $query = UserQuery::findOrFail($id);

        return view('admin.orders.query')->with(['query'=>$query]);
    }

    public function createOrderFromQuery(Request $request)
    {
        $order_data = $request->all();

        $order = new Order([
            'user_id' => $order_data['user_id'],
            'query_id' => $order_data['query_id'],
            'status' => 'new',
            'order_file_link' => '/some/location/file.pdf'
        ]);

        if($order->save())
        {
            $query = UserQuery::where('id', $order->query_id)->first();
            $query->status = 'approved';
            $query->save();

            foreach ($order_data['products'] as $product) {
                $custom_name = isset($product['custom_name']) ? $product['custom_name'] : null;
                for ($i = 1; $i <= $product['quantity']; $i++)
                {
                    DB::table('orders_products')
                        ->insert([
                            'order_id' => $order['id'],
                            'product_id' => $product['id'],
                            'custom_name' => $custom_name
                        ]);
                }
            }

            $notification = new UserNotification([
               'user_id' => $query->user_id,
               'title' => "Ваш запрос #{$query->id} успешно обработан",
               'message' => "Уважаемый {$query->user()->name}! Ваш запрос #{$query->id} успешно обработан нашим менеджером. Вы можете просмотреть новый заказ в личном кабинете в разделе Заказы",
               'tag' => 'important',
               'status' => 'unread'
            ]);
            $notification->save();

            return response('OK', 200);
        }

        return response('Unexpected error', 300);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.show')->with(['order'=>$order]);
    }
}
