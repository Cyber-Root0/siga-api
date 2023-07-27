<?php

namespace app\controller\Session;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;

Class Session extends Controller implements ControllerInterface{

    protected $header = "Content-Type: application/json; charset=utf-8";
    private $id = null;
    protected $pwd = null;


    public function index(){
       
        echo "";
      
    }

    public function Get(){

        

    }

    public function Post(){
        $this->id = Input::post("id");
        $this->pwd = Input::post("password");
        $this->create();

    }

    public function create(){

        if($this->validData()){
            
        }else{
            $this->setHeader();
            $this->response(array(
                "erro" => 400,
                "message" => "Dados invalidos"
            ));
        }

    }

    public function validData(){
        if (!empty($this->id) && !empty($this->pwd)){

            return true;
        }else{
            return false;
        } 
    }

    
}
