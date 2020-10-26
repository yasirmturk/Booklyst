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
        $user = $request->user();
        $searchPhrase = $request->q;
        $businesses = Business::where('name', 'like', "%$searchPhrase%")
            ->orWhere('description', 'like', "%$searchPhrase%")
            // ->orWhere('services.name', 'like', "%$searchPhrase%")
            // ->orWhere('products.name', 'like', "%$searchPhrase%")
            ->with(['services', 'products'])
            // ->with(['services.wishes', 'products.wishes'])
            // ->where('user_id', $user->id)
            ->get();
        $result = [];
        if (in_array($productOrService, ['all', 'service'])) {
            $services = $businesses->pluck('services')->collapse();
            $result['services'] = $services;
        }
        if (in_array($productOrService, ['all', 'product'])) {
            $products = $businesses->pluck('products')->collapse();
            $result['products'] = $products;
        }

        return $result;
    }
}
