<?php

if (!isset($_SESSION)) session_start();

require_once('vendor/autoload.php');

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__)->load();

$BASE="https://api.dpd.co.uk";

$method = ':/shipping/shipment';

$url = $BASE.$method;

if (isset($_SESSION['geoSession'])) {

    $json='{
        "job_id": null,
        "collectionOnDelivery": false,
        "invoice": null,
        "collectionDate": "2021-01-05T016:00:00",
        "consolidate": false,
        "consignment": [{
            "consignmentNumber": null,
            "consignmentRef": null,
            "parcels": [],
            "collectionDetails": {
            "contactDetails": {
            "contactName": "My Contact",
            "telephone": "0121 500 2500"
            },
            "address": {
            "organisation": "GeoPostUK Ltd",
            "countryCode": "GB",
            "postcode": "B66 1BY",
            "street": "Roebuck Lane",
            "locality": "Smethwick",
            "town": "Birmingham",
            "county": "West Midlands"
            }
            },
            "deliveryDetails": {"contactDetails": {
            "contactName": "My Contact",
            "telephone": "0121 500 2500"
            },
            "address": {
            "organisation": "GeoPostUK Ltd",
            "countryCode": "GB",
            "postcode": "B66 1BY",
            "street": "Roebuck Lane",
            "locality": "Smethwick",
            "town": "Birmingham",
            "county": "West Midlands"
            },
            "notificationDetails": {
            "email": "my.email@geopostuk.com",
            "mobile": "07921000001"
            }
            },
            "networkCode": "1^01",
            "numberOfParcels": 1,
            "totalWeight": 5,
            "shippingRef1": "My Ref 1",
            "shippingRef2": "My Ref 2",
            "shippingRef3": "My Ref 3",
            "customsValue": null,
            "deliveryInstructions": "Please deliver with neighbour",
            "parcelDescription": "",
            "liabilityValue": null,
            "liability": false
            }]
        }';

    $json=(str_replace(" ", "", $json));
    $json=(str_replace("\n", "", $json));
    $json=(str_replace("    ", "", $json));
    //exit();
    $length=strlen($json);
    // echo $length;
    
    $options = array(
    'http' => array(
        'method'  => 'POST',
        'Host'  => 'api.dpd.co.uk',
        'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n".
                    "GEOClient: ".$_ENV['DPD_USERNAME']."/".$_ENV['DPD_USER_ID']."\r\n".
                    "GEOSession: ".$_SESSION['geoSession']."\r\n".
                    "Content-Length: ".$length."\r\n",
        'content'=> $json
            )
    );

    // var_dump($options);
    $context = stream_context_create($options);
    // echo var_dump($context);
    $result = file_get_contents($url, false, $context);
    // echo $result;
    
    
    $response = json_decode($result);
    // var_dump($response);
    
    $data=(json_decode($result,true));
    var_dump($data);
    
    $shipmentId=$data['data']['shipmentId'];
    ///shipping/shipment/[shipmentId]/label/
    echo $shipmentId;

} else{

    echo "<p>GEO Session is not exists! Please must login first <a href='login.php'>login</a></p>";

}