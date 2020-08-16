<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function listCategories(Request $request)
    {
        $categories = Category::all();
        $data = [
            'categories' => $categories,
        ];
        return $data;
    }
}
