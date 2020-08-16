<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class MetaController extends Controller
{
    public function default(Request $request)
    {
        return [];
    }

    public function all(Request $request)
    {
        $categories = Category::all();
        $meta = [
            'categories' => $categories
        ];
        return $meta;
    }
}
