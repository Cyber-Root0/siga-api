<?php

namespace app\core;
use app\core\Auth\Auth;
use app\controller\Session\Cookie;
use app\classes\Input;
require_once('../app/functions/functions.php');
class controller extends Auth{
     
    protected $cookie;
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

    }
}