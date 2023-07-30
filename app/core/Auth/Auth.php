<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

namespace app\core\Auth;
use app\classes\Input;
class Auth
{
    
    protected function Auth(){

        $haveAuth = Input::getAuth();
    
        if (!$haveAuth){
            (new \app\controller\MessageController)->message404('401','Você não tem permissão para acessar essa API!!! Seu IP Foi armazenado');
            exit;
        }else{
            $isValid = $this->ValidateToken($haveAuth);
            if (!$isValid){
                (new \app\controller\MessageController)->message404('401','Seu token é invalido!!! Seu IP Foi armazenado');
                exit;
            }
        }   

    }

    protected function ValidateToken($token){

        if (!in_array($token, $this->getTokens())){
        
            return false;
        }else{
            return true;
        }

    }

    protected function getTokens(){
        $tokens = array();
        $users = json_decode(file_get_contents(__DIR__.'/tokens/auth.json'));
        foreach($users->users as $index => $user){
            $tokens[] = $user->token;
        }
        return $tokens;
    }



}
