<?php

namespace app\core;
use app\core\Auth\Auth;
require_once('../app/functions/functions.php');
class controller extends Auth{
     
    public function __construct(){

        $this->Auth();
        $this->setHeader();

    }

    public function response($data){
        echo json_encode($data);

    }

    public function setHeader(){
        header($this->header);
    }
    
}