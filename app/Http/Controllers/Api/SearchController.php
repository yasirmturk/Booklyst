<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
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

    public function listBusinessesInCategory(Request $request, $category)
    {
        return Category::findOrFail($category)->businesses()->get();
    }

    public function searchBusiness(Request $request, $productOrService)
    {
        $searchPhrase = $request->q;
        $businesses = Business::where('name', 'like', "%$searchPhrase%")
            ->orWhere('description', 'like', "%$searchPhrase%")
            ->with(['services', 'products'])
            ->get();
        $result = [];
        if (in_array($productOrService, ['all', 'service'])) {
            $services = $businesses->pluck('services');
            $result['services'] = $services;
        }
        if (in_array($productOrService, ['all', 'product'])) {
            $products = $businesses->pluck('products');
            $result['products'] = $products;
        }
        // $result = ['services' => $services, 'products' => $products];
        return $result;
    }
}
