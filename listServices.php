<?php

if (!isset($_SESSION)) session_start();

require_once('vendor/autoload.php');

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__)->load();

$BASE="https://api.dpd.co.uk";

$method = '/shipping/network/?businessUnit=0&deliveryDirection=1&numberOfParcels=1&shipmentType=0&totalWeight=1.0&deliveryDetails.address.countryCode=GB&deliveryDetails.address.countryName=&deliveryDetails.address.locality=&deliveryDetails.address.organisation=&deliveryDetails.address.postcode=EX34 8LY&deliveryDetails.address.property=&deliveryDetails.address.street=&deliveryDetails.address.town=&deliveryDetails.address.county=&collectionDetails.address.countryCode=&collectionDetails.address.countryName=&collectionDetails.address.locality=&collectionDetails.address.organisation=&collectionDetails.address.postcode=&collectionDetails.address.property=&collectionDetails.address.street=&collectionDetails.address.town=&collectionDetails.address.county=GB';

$url = $BASE.$method;

if (isset($_SESSION['geoSession'])) {
    
    $options = array(
        'http' => array(
            'method'  => 'GET',
            'Host'  => 'api.dpd.co.uk',
            'header'=>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n".
                        "GEOClient: ".$_ENV['DPD_USERNAME']."/".$_ENV['DPD_USER_ID']."\r\n".
                        "GEOSession: ".$_SESSION['geoSession']."\r\n".
                        "Content-Length: 0"
          )
    );
    
    $context     = stream_context_create($options);
    
    $result      = file_get_contents($url, false, $context);
    $response    = json_decode($result);
    echo $result;

} else{

    echo "<p>GEO Session is not exists! Please must login first <a href='login.php'>login</a></p>";

}