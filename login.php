<?php
$BASE="https://api.dpd.co.uk";

$method = '/user/?action=login';

$url = $BASE.$method;

$options = array(
    'http' => array(
        'method'  => 'POST',
        'Host'  => 'api.dpd.co.uk',
        'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n".
                    "Authorization: Basic ". base64_encode("username:password") ."\r\n".
                    "Content-Length: 0"
      )
);


$context     = stream_context_create($options);

$result      = file_get_contents($url, false, $context);
$response    = json_decode($result);
//echo var_dump($response);

$data=(json_decode($result,true));
$session=$data['data']['geoSession'];
echo $session;