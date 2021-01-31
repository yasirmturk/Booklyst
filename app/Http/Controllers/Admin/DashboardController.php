<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function index(Request $request)
    {
        return view('admin.dashboard')->with([
            'page_title' => 'Dashboard',
            'page_description' => 'Information overview',
        ]);
    }
}
