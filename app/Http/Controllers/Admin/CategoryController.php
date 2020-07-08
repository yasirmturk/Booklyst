<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Show the category dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        $data = [
            'page_title' => 'Business Category',
            'page_description' => 'List of all the business categories',
            'categories' => $categories,
        ];
        return view('admin.settings.category')->with($data);
    }
}
