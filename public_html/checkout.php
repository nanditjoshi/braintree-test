<?php
require_once("../includes/braintree_init.php");

$amount = $_POST["amount"];
$nonce = $_POST["payment_method_nonce"];


//CREATE CUSTOMER 

/* $result = $gateway->customer()->create([
    'firstName' => 'Mike',
    'lastName' => 'Jones',
    'company' => 'Jones Co.',
    'email' => 'mike.jones@example.com',
    'phone' => '281.330.8004',
    'fax' => '419.555.1235',
    'website' => 'http://example.com'
]); */

// FIND THE CUSTOMER FROM ID
// $customer = $gateway->customer()->find(198907690);

// ADD PAYMENT METHOD IN EXISTING CUSTOMER
 /* $result = $gateway->paymentMethod()->create([
    'customerId' => '198907690',
    'paymentMethodNonce' => $nonce
]);  */

// CREATE CUSTOMER AND PAYMENT METHOD ALL IN ONE
/* $result = $gateway->customer()->create([
    'firstName' => 'Nandit',
    'lastName' => 'Joshi',
    'paymentMethodNonce' => $nonce,
    'creditCard' => [
        'options' => [
            'verifyCard' => true
        ],
        'billingAddress' => [
            'firstName' => 'Nandit',
            'lastName' => 'Joshi',
            'company' => 'Braintree',
            'streetAddress' => '123 Address',
            'locality' => 'City',
            'region' => 'State',
            'postalCode' => '12345'
        ]
    ]
]);
 */

// FIND PAYMENT METHOD 
//$paymentMethod = $gateway->paymentMethod()->find('token');

// DO TRANSACTION WITH EXISTING USER DEFAULT PAYMENT METHOD
$result = $gateway->transaction()->sale(
    [
      'customerId' => '198907690',
      'amount' => '10.00'
    ]
  );


echo "<pre>";
print_r($result);
echo "</pre>";
die;


$result = $gateway->transaction()->sale([
    'amount' => $amount,
    'paymentMethodNonce' => $nonce,
    'options' => [
        'submitForSettlement' => true
    ]
]);

if ($result->success || !is_null($result->transaction)) {
    $transaction = $result->transaction;
    header("Location: " . $baseUrl . "transaction.php?id=" . $transaction->id);
} else {
    $errorString = "";

    foreach($result->errors->deepAll() as $error) {
        $errorString .= 'Error: ' . $error->code . ": " . $error->message . "\n";
    }

    $_SESSION["errors"] = $errorString;
    header("Location: " . $baseUrl . "index.php");
}
