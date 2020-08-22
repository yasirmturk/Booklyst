<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function register(Request $request)
    {
        $user = $request->user();
        $data = $this->validateBusiness($request);
        $business = Business::create($data);
        $business->users()->save($user);
        return $business->save();
    }

    public function mine(Request $request)
    {
        return $request->user()->businesses()->get();
    }

    public function find(Request $request, $id)
    {
        return Business::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $data = $this->validateBusiness($request);
        $business = Business::findOrFail($id);
        $business->update($data);
        return $business->save();
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
        ]);
    }
}
