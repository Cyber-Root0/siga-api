<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

namespace app\controller\horarios;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;
use app\classes\FixJson;
use app\controller\Session\Cookie;
use app\classes\HttpFactory;
use Exception;
use Symfony\Component\DomCrawler\Crawler;

Class horarios extends Controller{

    public $uid = null;
    public $siga = null;
    protected $header = "Content-Type:text/html; charset=utf-8";
    protected $http_client = null;

    protected Crawler $crawler;

    public function index(){

    }

    public function __construct(){

        $this->uid = Input::get("uid");
        $this->crawler = new Crawler;
        parent::__construct();
    }

    public function get(){
        
       
                if ($this->status_cookie){

                    $XML_HTML = $this->getContent($this->cookie->getCookie());
                    $this->crawler->addHtmlContent($XML_HTML);
                    //$horarios = $this->crawler->filter('input[name="GXState"]')->attr('value');  
                    $horarios =  $this->getHorarios();
                    $this->response($horarios);
                }else{

                    $this->response(array(
                            "error" => 400,
                            "msg" => "Crie uma sessão com um usuário válido"
                    )); 

                }

    }

    public function Post(){



    }
    
    private function getHorarios(){

        $daysWeek = array(
            null,
            null,
            "segunda",
            "terca",
            "quarta",
            "quinta",
            "sexta",
            "sabado",
            "domingo"
        );


            $flag = true;
            $i = 2;
            $horarios = array();
            while($flag){
                try{
                    $aulas = $this->crawler->filter("input[name='Grid{$i}ContainerDataV']")->attr('value');
                    $aulas = json_decode($aulas);
                    $dailyClasses = array();
                    foreach($aulas as $key=> $aula){
                        $dailyClasses[] = array(
                            "AULA" => $key,
                            "DISCIPLINA" => $aula[2],
                            "HORARIO" => $aula[1],
                            "TURMA" => $aula[3]
                        );
                    }    

                    $horarios[$daysWeek[$i]] = $dailyClasses;
                    
                    $i++;
                }catch(Exception $e){
                        $flag = false;
                }
                
            }
            
            return $horarios;

    }
    private function getContent($cookie){

        $http_client= new HttpFactory(
            "GET",
            "https://siga.cps.sp.gov.br/aluno/horario.aspx",
            null,
            null,
            $cookie
        );
        $response= $http_client->request();
        return $response->getBody()->getContents();
    }

    private function trataJson($dados){
        return null;        
    
    }

}
