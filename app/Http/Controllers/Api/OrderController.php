<?php

namespace App\Http\Controllers\Api;

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
        $user = $request->user();
        return $user->orders;
    }

    public function paid(Request $request, Order $order)
    {
        $user = $request->user();
        $bookings = $order->bookings;
        foreach ($bookings as $booking) {
            $booking->is_paid = true;
        }
        $order->is_paid = true;
        $order->save();
        $order->refresh();
        return $order;
    }
}
