<?php

namespace app\classes;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
class HttpFactory{
   
    private $url = null;
    private $path = null;
    private $client = null;
    private $cookie = null; 
    private $method = null;
    private $body = null;

     public function __construct($method,$url,$path,$body,$cookie=null){
        $this->method = $method;
        $this->url = $url;
        $this->body = $body;
        $this->cookie = $cookie;
        $this->client = new Client();

     }

     public function request(){

        $response = $this->client->request($this->method, $this->url . '/' . $this->path, [
            'body'    => $this->body, 
            'cookies' => $this->cookie,
            'headers' => [
               'content-type' => 'application/x-www-form-urlencoded', 
               'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7', 
               'charset' => 'utf-8',
               "Accept-Encoding" =>  "gzip, deflate, br"
               ]
        ]);
        return $response;
     }

     public function setCookie(){

        $this->cookie = CookieJar::fromArray([
            $this->cookie['name'] => $this->cookie['value']
        ], $this->url);

     }
   
    
}