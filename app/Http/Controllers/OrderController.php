<?php

namespace App\Http\Controllers;

use App\Order;
use App\UserQuery;
use Illuminate\Http\Request;

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

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.show')->with(['order'=>$order]);
    }
}
