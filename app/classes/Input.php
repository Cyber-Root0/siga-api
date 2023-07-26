<?php

namespace app\classes;
class Input{
    public static function get(string $param, int $filter = FILTER_SANITIZE_STRING){
        return filter_input(INPUT_GET, $param, $filter);
    }
    public static function post(string $param, int $filter = FILTER_SANITIZE_STRING){
        return filter_input(INPUT_POST, $param, $filter);
    }

    public static function getAuth(){

        if (isset($_SERVER['HTTP_AUTHORIZATION'])){
            $authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'];
            return $authorizationHeader;
        }else{
            return false;
        }

    }

    
}