<?php

namespace app\controller\Session;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;
use app\classes\CPF;

Class Session extends Controller implements ControllerInterface{

    protected $header = "Content-Type: application/json; charset=utf-8";
    private $id = null;
    protected $pwd = null;
    protected $path_dir = null;
    protected $uid = null;

    public function index(){
       
        echo "";
      
    }

    public function Get(){

        $this->uid = Input::get("uid");
        

    }

    public function Post(){
        $this->id = Input::post("id");
        $this->pwd = Input::post("password");
        $this->create();

    }

    public function create(){

        if($this->validData()){
            
            //Create USER ID
            $uid = $this->createUID();
            $this->makeDir($uid);
            $this->SaveSession();
            $this->response(
                array(
                    "code" => 200,
                    "message" => 'Sessão criada com sucesso',
                    "session_id" => $uid
                )
            );
        }

    }

    public function validData(){
        if (!empty($this->id) && !empty($this->pwd)){
            if (CPF::validaCPF($this->id)){
                return true;
            }else{
                $this->response($this->setBody(400, 'CPF inválido'));
            }

        }else{
            $this->response($this->setBody(400, 'Dados inválidos'));

        }
        
        
    }

    private function setBody($code, $msg){

        return array(
            "error" => $code,
            "msg" => $msg
        );
    }

    private function createUID(){
        $ran_bytes = random_bytes(15);
        $uid = bin2hex($ran_bytes);
        return $uid;
    }

    private function makeDir($uid){
        $this->path_dir = __DIR__.'/../../sessions/'.$uid;
        mkdir(__DIR__.'/../../sessions/'.$uid);
    }
    
    private function pack(){

        return json_encode(
            array(
                "Id" => $this->id,
                "Password" => $this->pwd
            )
        );

    }
    private function SaveSession(){

        file_put_contents($this->path_dir.'/user.json', $this->pack());

    }
}
