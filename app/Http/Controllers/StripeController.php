<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function billing(Request $request)
    {
        $user = $request->user();
        $stripeCustomer = $user->createOrGetStripeCustomer();
        // $url = $request->user()->billingPortalUrl(route('home'));
        return $user->redirectToBillingPortal(route('home'));
    }

    public function paymentMethods(Request $request)
    {
        $user = $request->user();
        return view('payment-methods', [
            'intent' => $user->createSetupIntent()
        ]);
    }
}
