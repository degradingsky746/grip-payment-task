<?php
session_start();
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

if ($contentType === "application/json") {
  $content = trim(file_get_contents("php://input"));

  $decoded = json_decode($content, true);
}

$_SESSION['name']=$decoded['name'];
$_SESSION['mail']=$decoded['mail'];
$_SESSION['amount']=$decoded['amount'];
//echo "<script>console.log('".$_SESSION['name']."')</script>";

require_once('stripe-php/init.php');
\Stripe\Stripe::setApiKey('secret key');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'https://covid-releif.000webhostapp.com/payment_gateway/';

$checkout_session = \Stripe\Checkout\Session::create([
  'payment_method_types' => ['card'],
  'line_items' => [[
    'price_data' => [
      'currency' => 'inr',
      'unit_amount' => $decoded['amount']*100,
      'product_data' => [
        'name' => 'Covid Relief Fund',
        'images' => ["https://images.unsplash.com/photo-1599059813005-11265ba4b4ce?ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8Y2hhcml0eXxlbnwwfHwwfHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60"],
      ],
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . 'success.php',
  'cancel_url' => $YOUR_DOMAIN . 'cancel.html',
]);

echo json_encode(['id' => $checkout_session->id]);