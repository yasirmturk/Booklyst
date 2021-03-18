<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $bankAccounts = $user->bankAccounts()->orderByDesc('id')->get();
        return $bankAccounts;
    }

    public function update(Request $request)
    {
        $data = $request->validate(BankAccount::$rules);
        $user = $request->user();
        $user->bankAccounts()->create($data);
        return $user->bankAccounts;
    }
}
