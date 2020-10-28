<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return $user->bookings()->get();
    }

    public function book(Request $request)
    {
        $user = $request->user();
        $service = Service::findOrFail($request->service_id);
        $amount = ($service->price - $service->discount);
        $booking = Booking::create([
            'user_id' => $user->id,
            'service_id' => $service->id,
            'service_time' => $request->service_time,
            'amount' => $amount,
            'status' => Booking::STATUS_BOOKED
        ]);
        $user->bookings()->save($booking);
        return $booking;
    }
}
