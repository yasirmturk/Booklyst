<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\Wish;
use Illuminate\Http\Request;

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
        if ($productOrService == 'service' && $this->findWishForService($productOrServiceId, $user->id)->doesntExist()) {
            $service = Service::findOrFail($productOrServiceId);
            $service->wishes()->create([
                'user_id' => $user->id,
            ]);
            $service->save();
        } else if ($productOrService == 'product' && $this->findWishForProduct($productOrServiceId, $user->id)->doesntExist()) {
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
            $this->findWishForService($productOrServiceId, $user->id)->delete();
        } else if ($productOrService == 'product') {
            $this->findWishForProduct($productOrServiceId, $user->id)->delete();
        }
        return;
    }

    private function findWishForService(int $id, int $userId)
    {
        return Wish::where([
            'wishable_type' => Service::class,
            'wishable_id' => $id,
            'user_id' => $userId,
        ]);
    }

    private function findWishForProduct(int $id, int $userId)
    {
        return Wish::where([
            'wishable_type' => Product::class,
            'wishable_id' => $id,
            'user_id' => $userId,
        ]);
    }
}
