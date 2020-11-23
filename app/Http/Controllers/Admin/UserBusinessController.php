<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class UserBusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $user)
    {
        // $user = $request->user;
        $businesses = $user->businesses()->orderBy('id', 'DESC')->get();
        return view('admin.business')->with(compact('businesses', $businesses));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Business $business
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
    }
}
