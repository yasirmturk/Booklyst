<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('welcome');
    }

    public function reset()
    {
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');

        return redirect()->intended(RouteServiceProvider::HOME)->with('status', 'Reset successfully');
    }
}
