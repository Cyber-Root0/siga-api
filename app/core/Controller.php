<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */


namespace app\core;
use app\core\Auth\Auth;
use app\controller\Session\Cookie;
use app\classes\Input;
use app\classes\FixJson;
use app\controller\Session\Crypto;
class Controller extends Auth{
      
    protected $cookie;
    protected $status_cookie = true;
    public function __construct(){

        
        $this->instanceCookie();
        $this->Auth();
        $this->setHeader();

    }

    public function response($data){
        echo json_encode($data);

    }

    public function setHeader(){
        header($this->header);
    }

    private function setBody($code, $msg){

        return array(
            "error" => $code,
            "msg" => $msg
        );
    }
    private function instanceCookie(){

        if (!empty(Input::get("uid"))){
            $this->cookie= new Cookie(Input::get("uid"));

        }else{
            $this->cookie= new Cookie(Input::post("uid"));
        }

        if($this->cookie->issetCookie()){
            if (!$this->cookie->validCookie()){
                
                $this->cookie->refresh();
            }
            
        }else{
            
            $this->status_cookie = false;
        }


    }

    public function fixJson($js){
       
        $dataH = FixJson::fix($js);
        
        return $dataH;
       

    }
}