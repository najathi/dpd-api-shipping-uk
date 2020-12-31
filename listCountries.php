<?php
$BASE="https://api.dpd.co.uk";

$method = '/shipping/country';

$url = $BASE.$method;

$options = array(
    'http' => array(
        'method'  => 'GET',
        'Host'  => 'api.dpd.co.uk',
        'header'=>  "Accept: application/json\r\n"
    )
);

$context     = stream_context_create($options);

$result      = file_get_contents($url, false, $context);
$response    = json_decode($result);
echo $result;