<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Image;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Service;
use App\Traits\CloudUpload;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    use CloudUpload;

    public function register(Request $request)
    {
        $user = $request->user();
        $data = $request->validate(Business::$rules);
        $business = Business::create($data);
        if ($request->has('description')) {
            $business->description = $request->description;
        }
        $business->users()->save($user);
        $business->categories()->attach($request->categories);
        $business->schedule()->create([]);
        $business->refresh();
        return $business;
    }

    public function mine(Request $request)
    {
        $user = $request->user();
        return $user->businesses()
            ->with(['categories:categories.id,name', 'products', 'services'])
            ->get();
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
        $data = $request->validate(Business::$rules);
        $business->update($data);
        $business->categories()->sync($request->categories);
        // $business->categories()->syncWithoutDetaching($request->categories);
        $business->save();
        $business->categories = $business->categories;
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
        $data = $request->validate(Service::$rules);
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
        $data = $request->validate(Product::$rules);
        $data['business_id'] = $business->id;
        $product = Product::create($data);
        if ($request->has('description')) {
            $product->description = $request->description;
        }
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

    public function getSchedule(Request $request, Business $business)
    {
        return $business->schedule
            ?? response(['message' => 'No Schedule found'], 404);
    }

    /**
     * Update the specified schedule for business.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Business $business
     * @return \Illuminate\Http\Response
     */
    public function addSchedule(Request $request, Business $business)
    {
        $data = $request->validate(Schedule::$rules);
        $business->schedule()->delete();
        $business->schedule()->create($data);
        $business->refresh();
        return $business;
    }

    public function removeSchedule(Request $request, Business $business)
    {
        $business->schedule()->delete();
        $business->refresh();
        return $business;
    }
}
