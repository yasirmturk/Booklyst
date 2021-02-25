<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::check()) {
            // The user is logged in...
            // Get the currently authenticated user...
            $user = Auth::user();

            // Get the currently authenticated user's ID...
            $id = Auth::id();
            // $request->user() returns an instance of the authenticated user...
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('home');
    }

    public function settings(Request $request)
    {
        $user = $request->user();
        $bankAccount = $user->bankAccounts()->first();
        return view('settings')->with(compact($bankAccount));
    }
}
