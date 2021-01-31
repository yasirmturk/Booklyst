<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function provider(Request $request)
    {
        $user = $request->user();
        $customer = $user->createOrGetStripeCustomer();
        $data = $request->validate([
            'paymentMethodId' => 'required|string'
        ]);
        // $paymentMethodId = $user->paymentMethods()->first();
        $providerPlan = config('stripe.subscriptions.provider');
        $trialDays = config('stripe.subscriptions.trial_days');
        if ($user->subscribedToPlan($providerPlan, 'default')) {
            // return $customer->subscriptions->data;
            return $user->subscription('default')
                ->findItemOrFail($providerPlan);
        } else {
            return $user->newSubscription('default', $providerPlan)
                ->trialDays($trialDays)
                ->create($data['paymentMethodId']);
        }
    }
}
