<?php

return [
    "key" => env('STRIPE_KEY'),
    "subscriptions" => [
        "provider" => env('PROVIDER_PRICE_ID'),
        "trial_days" => env('PROVIDER_TRIAL_DAYS'),
    ],
];
