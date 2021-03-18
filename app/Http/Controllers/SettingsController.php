<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\SettingsController as ApiSettingsController;
use Illuminate\Http\Request;

class SettingsController extends ApiSettingsController
{
    public function index(Request $request)
    {
        $bankAccounts = parent::index($request);
        $bankAccount = $bankAccounts->first();
        return view('settings')->with(compact('bankAccount'));
    }

    public function update(Request $request)
    {
        $bankAccounts = parent::update($request);
        return redirect()->route('settings')
            ->with('success', 'Bank account saved successfully.');
    }
}
