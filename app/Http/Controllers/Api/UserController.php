<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use App\Traits\CloudUpload;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Stripe\EphemeralKey;
use Stripe\PaymentIntent;

class UserController extends Controller
{
    use CloudUpload;

    /**
     * Display the currency logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function current(Request $request)
    {
        $user = $request->user();
        $customer = $user->createOrGetStripeCustomer();
        // $customer = $user->updateStripeCustomer();
        $paymentMethods = $user->paymentMethods();
        $user->updateDefaultPaymentMethodFromStripe();
        $paymentMethod = $user->defaultPaymentMethod();
        return array_merge($user->toArray(), [
            // 'customer' => $customer,
            'subscriptions' => $customer->subscriptions->data,
            'paymentMethods' => $paymentMethods,
            'defaultMethod' => $paymentMethod,
            'hasPaymentMethod' => $user->hasPaymentMethod(),
            'sources' => $customer->sources->data,
        ]);
    }

    /**
     * Get the stripe for logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $request)
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

    public function addStripeMethod(Request $request)
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
     * Get the provider subscription for logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function provider(Request $request)
    {
        $customer = $request->user()->createOrGetStripeCustomer();
        $providerPriceId = config('stripe.subscriptions.provider');
        $params = Cashier::stripeOptions();
        $intent = PaymentIntent::create([
            ['customer' => $customer->id, 'price' => $providerPriceId],
            $params
        ]);
        $client_secret = $intent->client_secret;
        return $client_secret;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::orderBy('id', 'DESC')->get();
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user = $request->user();
        $user->name = $request->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->hashName();
            $url = $this->uploadToCloud($file, $filename);
            $image = Image::create([
                'filename' => $filename,
                'url' => $url
            ]);
            $user->images()->save($image);
        }

        $user->save();
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response('User deleted successfully');
    }
}
