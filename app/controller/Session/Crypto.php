<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */
namespace app\controller\Session;
Class Crypto {

    protected $private_key = null;
    public function __construct($private_key = null){
        $this->private_key = $private_key;
    }


    public static function random(){
        $r = random_bytes(30);
        return base64_encode($r);
    }

    public static function get_private_uid($uid){

        $data = explode("@",$uid);
        return $data[1];

    }


}
