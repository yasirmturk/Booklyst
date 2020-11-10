<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function register(Request $request)
    {
        $user = $request->user();
        $data = $this->validateBusiness($request);
        $business = Business::create($data);
        $business->users()->save($user);
        $business->categories()->attach($request->categories);
        $business->save();
        return $business;
    }

    public function mine(Request $request)
    {
        return $request->user()->businesses()->get();
    }

    public function find(Request $request, $id)
    {
        $business = Business::findOrFail($id);
        $business['services'] = $business->services()->get();
        $business['products'] = $business->products()->get();
        return $business;
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $data = $this->validateBusiness($request);
        $business = Business::findOrFail($id);
        $business->update($data);
        return $business->save();
    }

    public function addService(Request $request, $id)
    {
        $user = $request->user();
        $business = Business::findOrFail($id);
        $data = $this->validateService($request);
        $data['business_id'] = $id;
        $service = Service::create($data);
        $business->services()->save($service);
        return $service;
    }

    public function removeService(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->business()->dissociate();
        $service->delete();
    }

    public function addProduct(Request $request, $id)
    {
        $user = $request->user();
        $business = Business::findOrFail($id);
        $data = $this->validateProduct($request);
        $data['business_id'] = $id;
        $product = Product::create($data);
        $business->products()->save($product);
        return $product;
    }

    public function removeProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->business()->dissociate();
        $product->delete();
    }

    private function validateService(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|min:1',
            'price' => 'required|min:0',
            'discount' => 'integer|min:0|max:100'
        ]);
    }

    private function validateProduct(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|min:0',
            'discount' => 'integer|min:0|max:100'
        ]);
    }

    private function validateBusiness(Request $request)
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'is_service' => 'required|boolean',
            'is_product' => 'required|boolean',
            'type' => 'required|in:' . implode(',', Business::$types),
            'employee_count' => 'integer',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|min:7|max:15',
            'categories' => 'required|array|size:1'
        ]);
    }
}
