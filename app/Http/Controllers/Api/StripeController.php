<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\EphemeralKey;
use Stripe\PaymentIntent;

class StripeController extends Controller
{
    /**
     * Get the stripe for logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $customer = $user->createOrGetStripeCustomer();
        $params = Cashier::stripeOptions();
        $key = EphemeralKey::create(
            ['customer' => $customer->id],
            $params
        );
        return $key;
    }

    public function addMethod(Request $request)
    {
        $request->validate([
            'paymentMethod' => 'required|string',
        ]);
        $user = $request->user();
        $paymentMethod = $request->paymentMethod;
        $user->addPaymentMethod($paymentMethod);
        $user->updateDefaultPaymentMethod($paymentMethod);
        return $user;
    }

    /**
     * Charge the payment for user
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);
        $user = $request->user();
        $customer = $request->user()->createOrGetStripeCustomer();
        $params = Cashier::stripeOptions();
        $intent = PaymentIntent::create(
            [
                'customer' => $customer->id,
                'amount' => $request->amount,
                'currency' => $user->preferredCurrency()
            ],
            $params
        );
        $client_secret = $intent->client_secret;
        return $client_secret;
    }
}
