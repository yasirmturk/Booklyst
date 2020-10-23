<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\Wish;
use App\Traits\Wishable;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class WishController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $wishlist = $user->wishlist()->with('wishable')->get();
        return [
            'services' => $wishlist->where('wishable_type', Service::class)->pluck('wishable'),
            'products' => $wishlist->where('wishable_type', Product::class)->pluck('wishable')
        ];
    }

    public function addToWish(Request $request, $productOrService)
    {
        $user = $request->user();
        $productOrServiceId = $request->id;
        if ($productOrService == 'service') {
            $service = Service::findOrFail($productOrServiceId);
            $service->wishes()->create([
                'user_id' => $user->id,
            ]);
            $service->save();
        } else if ($productOrService == 'product') {
            $product = Product::findOrFail($productOrServiceId);
            $product->wishes()->create([
                'user_id' => $user->id,
            ]);
            $product->save();
        }
        return;
    }

    public function removeFromWish(Request $request, $productOrService)
    {
        $user = $request->user();
        $productOrServiceId = $request->id;
        if ($productOrService == 'service') {
            // Wish::delete(Wishable)
        } else if ($productOrService == 'product') {
        }
        return;
    }
}
