<?php
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