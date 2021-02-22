<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return $user->bookings()->where('bookings.is_paid', true)->get();
    }

    /**
     *
     */
    public function book(Request $request)
    {
        $user = $request->user();
        // Check service
        $service = Service::findOrFail($request->service_id);
        $amount = ($service->price - $service->discount);
        // Create or get the cart
        $order = $user->orders()->whereIsPaid(false)->whereIsCancelled(false)->first();
        if (!$order) {
            $order = new Order(['amount' => $amount]);
            $user->orders()->save($order);
        } else {
            $order->amount += $amount;
        }
        $booking = new Booking([
            'service_id' => $service->id,
            'service_time' => $request->service_time,
            'amount' => $amount,
            'status' => Booking::STATUS_BOOKED
        ]);
        $order->bookings()->save($booking);
        $order->refresh();
        return $order;
    }
}
