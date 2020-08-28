<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $orders = Order::all();

        return view('admin.orders.index')->with(['orders' => $orders]);
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('admin.orders.show')->with(['order'=>$order]);
    }
}
