<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Image;
use App\Models\Product;
use App\Models\Service;
use App\Traits\CloudUpload;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    use CloudUpload;

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

    public function find(Request $request, Business $business)
    {
        $user = $request->user();
        // $business = Business::findOrFail($id);
        $business['services'] = $business->services()->get();
        $business['products'] = $business->products()->get();
        return $business;
    }

    public function update(Request $request, Business $business)
    {
        $user = $request->user();
        $data = $this->validateBusiness($request);
        // $business = Business::findOrFail($id);
        $business->update($data);
        $business->save();
        return $business;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Business $business
     * @return \Illuminate\Http\Response
     */
    public function addImage(Request $request, Business $business)
    {
        $request->validate([
            'image' => 'required|file',
        ]);

        $file = $request->file('image');
        $filename = $file->hashName();
        $url = $this->uploadToCloud($file, $filename);
        $image = Image::create([
            'filename' => $filename,
            'url' => $url
        ]);
        $business->images()->save($image);
        return $business;
    }

    public function removeImage(Request $request, Business $business)
    {
        $request->validate([
            'filename' => 'required|string',
        ]);
        $image = Image::firstWhere('filename', $request->filename);
        if ($image) {
            $business->images()->detach($image);
            $image->delete();
        }
        return $business;
    }

    public function addService(Request $request, Business $business)
    {
        $user = $request->user();
        // $business = Business::findOrFail($id);
        $data = $this->validateService($request);
        $data['business_id'] = $business->id;
        $service = Service::create($data);
        $business->services()->save($service);
        return $service;
    }

    public function removeService(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->business()->dissociate();
        $service->delete();
        return true;
    }

    public function addProduct(Request $request, Business $business)
    {
        $user = $request->user();
        // $business = Business::findOrFail($id);
        $data = $this->validateProduct($request);
        $data['business_id'] = $business->id;
        $product = Product::create($data);
        $business->products()->save($product);
        return $product;
    }

    public function removeProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->business()->dissociate();
        $product->delete();
        return true;
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
