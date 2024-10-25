<?php
require 'vendor/autoload.php';
if(1){
$stripe = new \Stripe\StripeClient('sk_test_51QBg4yHYNor937E51fPY8MjVMeiKIao5IAfo9fFXPU7op8zl8Yxg8PZdSuzQPBIpkLoSwQAJRFiLkYk4PjTS5LVM00wubiMHHO');

// Use an existing Customer ID if this is a returning customer.
$customer = $stripe->customers->create(
  [
    'name' => 'Mauricio',
    'address' => [
      'line1' => 'demo address',
      'postal_code' => '10901',
      'city' => 'El Salvador',
      'state' => 'SV',
      'country' => 'SV',
    ],
  ]

);
$ephemeralKey = $stripe->ephemeralKeys->create([
  'customer' => $customer->id,
], [
  'stripe_version' => '2024-09-30.acacia',
]);

$paymentIntent = $stripe->paymentIntents->create([
  'amount' => 199,
  'description' => 'Software development services',
  'currency' => 'usd',
  'customer' => $customer->id,
  // In the latest version of the API, specifying the `automatic_payment_methods` parameter
  // is optional because Stripe enables its functionality by default.
  'automatic_payment_methods' => [
    'enabled' => 'true',
  ],
]);

echo json_encode(
  [
    'paymentIntent' => $paymentIntent->client_secret,
    'ephemeralKey' => $ephemeralKey->secret,
    'customer' => $customer->id,
    'publishableKey' => 'pk_test_51QBg4yHYNor937E50dBqErWhL19NKgQqJ6FAY7QrdRK0gnjMWNywnznXci7JfjJZUEG1renfcrUGIaNoCyR5W3oN00BZzjPaw7'
  ]
);
http_response_code(200);
}