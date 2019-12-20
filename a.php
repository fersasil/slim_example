<?php
require_once 'vendor/autoload.php';

class Bot {
private $client;
private $email;
private $password;
private $server;
private $country;
private $base_url;
private $headers;

function __construct ($email, $password, $proxy = "" ){
    $this->client = new \GuzzleHttp\Client(['cookies' => true, 'proxy' => $proxy]);

    $this->headers = array();
    $this->headers[] = 'Authority: lobby.ikariam.gameforge.com';
    $this->headers[] = 'Accept: application/json';
    $this->headers[] = 'Origin: https://lobby.ikariam.gameforge.com';
    $this->headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.88 Safari/537.36';
    $this->headers[] = 'Content-Type: application/json';
    $this->headers[] = 'Sec-Fetch-Site: same-origin';
    $this->headers[] = 'Sec-Fetch-Mode: cors';
    $this->headers[] = 'Referer: https://lobby.ikariam.gameforge.com/pt_BR/';
    $this->headers[] = 'Accept-Encoding: gzip, deflate, br';
    $this->headers[] = 'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7';
    $this->headers[] = 'Cookie: pc_idt=AJgBxM6f-RNtY0DD02exhCvW7eFulOk3ul4R32dkET0rlQ6z3pvyxuc982CX40ZjDi8JZE6LIb5uaS7vRlK4Sn4c1Bcxj74-2IGGpQEZUpYzwXZdSRUA_s9p9RwX8FewOvDQsif5EqHdsQT32DhHfUA006nZvJ6P4RDj6w; never_logged_in=false';

    $this->email = $email;
    $this->password = $password;
}

function login(){
    $data = [
        "credentials" => [
            "email" => $this->email,
            "password" => $this->password,
        ],
        "language" => "br",
        "kid" => "",
        "autoLogin" => "false"
    ];

    $response = $this->client->request('POST', 'https://lobby.ikariam.gameforge.com/api/users', [
        "headers" => $this->headers,
        "form_params" => $data
    ]);
    
    
    $response = $this->client->request('GET', 'https://lobby.ikariam.gameforge.com/api/users/me/accounts');
    
    
    $response = $this->client->request('GET', 'https://lobby.ikariam.gameforge.com/api/users/me/loginLink?id=1895&server[language]=br&server[number]=44&clickedButton=account_l');
    
    $json_response  = $response->getBody()->getContents();
    
    $login_url = json_decode($json_response)->url;
    
    
    $response = $this->client->request('GET', $login_url);
    
    $body  = $response->getBody()->getContents();

    var_dump($body);
  }
}

$bot = new Bot("gfersasil@gmail.com", "20042040");
$bot->login();