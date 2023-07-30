<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

namespace app\controller;
use app\core\Controller;
class MessageController extends Controller{

    // Main of the Project
    public function __construct(){
        
    }
    public function message404(string $title, string $message){
        echo "<h1> $title </h1>";
        echo "<p> $message </p>";
    }

    

}