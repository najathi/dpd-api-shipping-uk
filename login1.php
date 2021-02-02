<?php

// login - method 1

session_start();

require_once('vendor/autoload.php');

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__)->load();

$BASE="https://api.dpd.co.uk";

$method = '/user/?action=login';

$url = $BASE.$method;

$options = array(
    'http' => array(
        'method'  => 'POST',
        'Host'  => 'api.dpd.co.uk',
        'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n".
                    "Authorization: Basic ". base64_encode($_ENV['DPD_USERNAME'].':'.$_ENV['DPD_PASSWORD']) ."\r\n".
                    "Content-Length: 0"
      )
);


$context     = stream_context_create($options);

$result      = file_get_contents($url, false, $context);
$response    = json_decode($result);
//echo var_dump($response);

$data=(json_decode($result,true));
$session=$data['data']['geoSession'];

// store to session variable
$_SESSION["geoSession"] = $session;

if ($_SESSION["geoSession"]) {
    header("Location: ./insertShipment.php");
    die();
}

echo $session;