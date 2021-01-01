<?php
$BASE="https://api.dpd.co.uk";

$method = '/shipping/network/?collectionDetails.address.locality=Birmingham&collectionDetails.address.county=West Midlands&collectionDetails.address.postcode=B661BY&collectionDetails.address.countyCode=GB&deliveryDetails.address.locality=Birmingham&deliveryDetails.address.county=West Midlands&deliveryDetails.address.postcode=B11AA&deliveryDetails.address.countyCode=GB&deliveryDirection=1&numberOfParcels=1&totalWeight=5&shipmentType=0&collectionDetails.address.countryCode=GB&deliveryDetails.address.countryCode=GB';

$url = $BASE.$method;

$options = array(
    'http' => array(
        'method'  => 'GET',
        'Host'  => 'api.dpd.co.uk',
        'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n".
                    "GEOClient: account/123456\r\n".
                    "GEOSession: ".$session."\r\n".
                    "Content-Length: 0"
      )
);

$context     = stream_context_create($options);

$result      = file_get_contents($url, false, $context);
$response    = json_decode($result);
echo $result;