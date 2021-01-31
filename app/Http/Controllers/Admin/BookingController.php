<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function index(Request $request)
    {
        $page_title = 'Bookings';
        $page_description = 'Bookings overview';

        $bookings = Booking::orderBy('id', 'DESC')->get();
        return view('admin.bookings')->with(compact('bookings', 'page_title', 'page_description'));
    }
}
