<?php

namespace app\controller\Session;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
 class Cookie{

    protected $uid = null;
    protected $path = null;
    protected $filename = null;
    protected $cookie = null;
    protected $client_http = null;
    public function __construct($uid){

        $this->uid = $uid;
        $this->cookie = null;
        $this->path = __DIR__.'/../../sessions/'.$this->uid;
        $this->filename = "/browser.json"; 
        $this->client_http = new Client(['cookies' => true]);
    }

    public function getCookie(){
        
        if ($this->issetCookie()){

            if($this->validCookie()){

                return $this->cookie;

            }else{
               return $this->refresh();
            }

        }else{

           return $this->create();

        }


    }
    public function issetCookie(){

        if ( file_exists($this->path.$this->filename) ){

            return true;
        }else{
            return false;
        }

    }

    private function validCookie(){

        $data = $this->getSavedCookie();
        $this->cookie = CookieJar::fromArray([
            $data[0] => $data[1]
        ], DOMAIN_SIGA);

        $response = $this->requestLogin("GET", PAGE_ALL_HISTORY, null, $this->cookie);
        if ($response->getStatusCode()==303){
            return false;
        }else{
            return true;
        }
        //echo $response->getStatusCode();
    }

    private function create(){

        $data = file_get_contents($this->path."/user.json");
        $data = json_decode($data);

        $response = $this->requestLogin("POST", PAGE_LOGIN, $this->setBody($data));

        $status_code = $response->getStatusCode();
        if ($status_code==303){

            $cookies = $this->treatCookie($response->getHeader('Set-Cookie')[0]);
            $this->saveCookie($cookies);
            return $cookies;
        }else{
            return false;
        }  
           
    }

    private function requestLogin($method, $url, $data=null, $cookie = null){

        return $this->client_http->request($method, $url, [
            'form_params'    => $data, 
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                "Accept-Encoding" => 'gzip, deflate',
                'Accept-Charset' => 'utf-8',
            ],
             "allow_redirects" => false,
             "cookies" => $cookie,
        ]);

    }

    private function refresh(){

        $data = file_get_contents($this->path."/user.json");
        $data = json_decode($data);

        $response = $this->requestLogin("POST", PAGE_LOGIN, $this->setBody($data));

        $status_code = $response->getStatusCode();
        if ($status_code==303){

            $cookies = $this->treatCookie($response->getHeader('Set-Cookie')[0]);
            $this->SaveCookie($cookies);
            return $cookies;
        }else{
            return false;
        }  


    }

    private function setBody($data){
        $body = array();
        $body["vSIS_USUARIOID"] = $data->Id;
        $body["vSIS_USUARIOSENHA"] = $data->Password;
        $body["BTCONFIRMA"] = "Confirmar";
        $body["GXState"] = SIGA_REQUEST_LOGIN;
        return $body;
    }

    private function saveCookie($cookie){

        file_put_contents($this->path.$this->filename,json_encode(
            $cookie
        ));

    }

    private function getSavedCookie(){

        return json_decode(
            file_get_contents($this->path.$this->filename)
        );

    }


    private function treatCookie($cookie){

        $CA = explode(";", $cookie);
        $C2 = $CA[0];
        $C3 = explode("=", $C2);
        
        return array(
            $C3[0],$C3[1]
        );
    }

 }


