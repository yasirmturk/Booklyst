<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $bankAccount = $user->bankAccounts()->orderByDesc('id')->first();
        return view('settings')->with(['bankAccount' => $bankAccount]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'country_code' => 'required',
            'currency_code' => 'required',
            'account_number' => 'required|numeric',
            'sort_code' => 'required|numeric',
        ]);
        $user = $request->user();
        $user->bankAccounts()->create($data);
        return redirect()->route('settings')
            ->with('success', 'Bank account saved successfully.');
    }
}
