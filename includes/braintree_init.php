<?php
session_start();
require_once('../vendor/autoload.php');

if(file_exists(__DIR__ . '/../.env')) {
    $dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
    $dotenv->load();
}

// if (!getenv('BT_ENVIRONMENT') || !getenv('BT_MERCHANT_ID') || !getenv('BT_PUBLIC_KEY') || !getenv('BT_PRIVATE_KEY')) {
//     throw new Exception('Cannot find necessary environmental variables. See https://github.com/braintree/braintree_php_example#setup-instructions for instructions');
// }

$gateway = new Braintree\Gateway([
    'environment' => 'sandbox',
    'merchantId' => '8vmhzvrzngd4m8kh',
    'publicKey' => '8zdg2dh9mvtv82bh',
    'privateKey' => '5b85fd88fa17fe33acb8cbce99695e77'
]);
$baseUrl = stripslashes(dirname($_SERVER['SCRIPT_NAME']));
$baseUrl = $baseUrl == '/' ? $baseUrl : $baseUrl . '/';
