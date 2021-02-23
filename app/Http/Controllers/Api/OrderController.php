<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function index(Request $request)
    {
        $user = $request->user();
        return $user->orders;
    }
}
