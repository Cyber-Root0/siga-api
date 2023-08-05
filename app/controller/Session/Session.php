<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */


namespace app\controller\Session;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;
use app\classes\CPF;
use app\classes\Files;
use app\controller\Session\Crypto;
use app\controller\Session\Cookie;

Class Session extends Controller implements ControllerInterface{

    protected $header = "Content-Type: application/json; charset=utf-8";
    private $id = null;
    protected $pwd = null;
    protected $path_dir = null; 
    protected $uid = null;
    
    private $private_key = null;

    public function index(){
       
        echo "";
      
    }

    public function Get(){

        $this->uid = Input::get("uid");
        

    }

    public function Post(){
        $this->id = Input::post("id");
        $this->pwd = Input::post("password");
        $this->path_dir = __DIR__.'/../../sessions/'.$this->id;
        $this->create();

    }

    public function create(){

        if($this->validData()){
            
            //Create USER ID
            $this->uid = $this->createUID();
            $this->setPath();
            Files::makeDir();
            $this->SaveSession();
            
            $this->response(
                array(
                    "code" => 200,
                    "message" => 'Sessão criada com sucesso',
                    "session_id" => $this->uid."@".$this->private_key
                )
            );
            
            
        }

    }

    public function deleteSession(){
        $this->uid = Input::post("uid");
        
        $this->setPath();
        
        if (self::issetSession()){
            Files::removeDir();
            $this->response(
                array(
                    "code" => 200,
                    "message" => 'Sessão excluida com sucesso',
                    "uid" => $this->uid
                )
            );
        }else{
            $this->response(
                array(
                    "code" => 404,
                    "message" => 'Essa Sessão não existe',
                    "uid" => $this->uid
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

    private function setPath(){
        $path = Input::post("uid");
        $this->path_dir=__DIR__.'/../../sessions/'.Crypto::get_uid_key($path);
        Files::$path = $this->path_dir;
    }
    private function setBody($code, $msg){

        return array(
            "error" => $code,
            "msg" => $msg
        );
    }

    public static function issetSession(){
        return Files::issetDir();
    }


    private function createUID(){

        //Private Key
        $this->private_key = Crypto::random();

        //UID
        $ran_bytes = random_bytes(15);
        $uid = bin2hex($ran_bytes);
        return $uid;
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

        Files::createFile('user.json',$this->pack(), $this->private_key);
        //create a new Cookie
        $cookie = new Cookie($this->uid."@".$this->private_key);
        $cookie->create();

    }
}
