<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function index(Request $request)
    {
        $page_title = 'Orders';
        $page_description = 'Orders overview';

        $orders = Order::orderBy('id', 'DESC')->get();
        return view('admin.orders')->with(compact('orders', 'page_title', 'page_description'));
    }
}
