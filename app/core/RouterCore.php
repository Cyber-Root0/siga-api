<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

namespace app\core;

class RouterCore{

    private $uri;
    private $method;
    private $getArr = [];

    private $postArr = [];

    public function __construct(){
       $this->initialize();
       $this->setRoute();
       $this->execute();

    }

    private function setRoute(){

        if( strpos( $_SERVER['SERVER_SOFTWARE'], 'Apache') !== false){
            require_once('../app/config/Router.php');
       }else{
            //@require_once($_SERVER['DOCUMENT_ROOT'].'/../app/config/Router.php');
            @require_once(__DIR__.'/../config/Router.php');
       }
    }
    private function initialize(){
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $_SERVER['REQUEST_URI'];
        //$_SESSION['nome'] = "Bruno";

        //tratamento do URI, conflito com Query string
        if (strpos($this->uri, '?'))
            $this->uri = mb_substr($this->uri, 0, strpos($this->uri, '?'));

        $ex = explode('/',$this->uri);
        
        $uri = $this->normalizeURI($ex);
        
        for($i = 0; $i< UNSET_URI_COUNT; $i++){
            unset($uri[$i]);
        }
        $uri = $this->normalizeURI($uri);
        //$this->uri = implode('/', $this->normalizeURI($uri));
       // $uri = $this->uri;
        if (DEBUG_URI)
            dd($uri);
        
    }

    private function execute(){
        switch($this->method){
            case 'GET':
                $this->executeGet();
                break;
            case 'POST':
                $this->executePOST();
                break;
        }
    }

    private function executeGet(){
        $error_ = true;
        foreach($this->getArr as $get){
           //dd($get,false);
           //echo $get['router'] . ' - '.$this->uri.'<br>';
           if ($get['router'] == $this->uri || $get['router'].'/' == $this->uri ){
                if (is_callable($get['call'])){
                    $error_ = false;
                    $get['call']();
                    break;
                }else{
                    $error_ = false;
                    $this->executeController($get['call']);
                    break;
                    
                }
                
           }
           
        }
        if ($error_){
            //exibição da pagina 404, quando a rota não existe
        
            (new \app\controller\MessageController)->message404('404','Essa pagina não existe!');
        }
        
    }

    private function executePOST(){
        $error_ = true;
        foreach($this->postArr as $get){
           //dd($get,false);
           //echo $get['router'] . ' - '.$this->uri.'<br>';
           if ($get['router'] == $this->uri || $get['router'].'/' == $this->uri ){
                if (is_callable($get['call'])){
                    $error_ = false;
                    $get['call']();
                    break;
                }else{
                    $error_ = false;
                    $this->executeController($get['call']);
                    break;
                    
                }
                
           }
           
        }
        if ($error_){
            //exibição da pagina 404, quando a rota não existe
        
            (new \app\controller\MessageController)->message404('404','Essa pagina não existe!');
        }
        
    }


    private function executeController($get){
        $ex = explode("@",$get);
        
       // dd($ex);
        if (!isset($ex[0]) || !isset($ex[1]) ){
            (new \app\controller\MessageController)->message404('404','Essa Controller, ou método não existe.');
            return;
        }

        $const = 'app\\controller\\'.$ex[0];
        
        //dd($const);
        if (!class_exists($const)){
            (new \app\controller\MessageController)->message404('404','controller não existe.');
            return;
        }
        if (!method_exists($const,$ex[1])){
            (new \app\controller\MessageController)->message404('404','método não existe.');
            return;
        }

        call_user_func_array([
            new $const,
            $ex[1]
           ],[]);
           
        
       // dd($ex);
        
    }

    private function get($router,$call){
        $this->getArr [] = [
            'router' => $router,
            'call' => $call
        ];

    }

    private function post($router,$call){
        $this->postArr [] = [
            'router' => $router,
            'call' => $call
        ];

    }

    private function normalizeURI($arr){
        return array_values( array_filter($arr) );

    }
}