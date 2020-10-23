<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index(Request $request)
    {
        return view('developer');
    }
}
