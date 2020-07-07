<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Show the category dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['page_title'] = 'Business Category';
        $data['page_description'] = 'List of all the business categories';
        return view('admin.settings.category')->with($data);
    }
}
