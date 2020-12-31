<?php

class Authentication {
    private $url;
    private $timeout;
    private $ch;
    private $headers;
    private $username;
    private $password;
    private $accountNo;
    public function __construct($url, $username, $password, $accountNo, $timeout='5', $headers=array()) {
        $this->headers = array( 'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: Basic ' . base64_encode($username . ':' . $password),
            'GEOClient: ' . $username . '/' . $accountNo,
            'Content-Length: 0'
        );
        $this->url = $url . '/user/?action=login';
        $this->timeout = $timeout;
        $this->headers = array_merge($this->headers, $headers);
        $this->ch = curl_init();
    }
    public function __destruct() {
        curl_close($this->ch);
    }
    public function doAuthentication() {
        curl_setopt_array($this->ch, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => $this->timeout,
            CURLOPT_USERAGENT => 'Spry Web Design dev',
            CURLOPT_HTTPHEADER => $this->headers,
            CURLOPT_POST => true
        ));
        $authPost = curl_exec($this->ch);
        $data = json_decode($authPost, true);
        return $data['data']['geoSession'];
    }
};

// example usage below
$client = new Authentication("https://api.dpd.co.uk", 'username', 'password', 'id');
$result = $client->doAuthentication();
echo $result;