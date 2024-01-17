<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

namespace app\controller\faltas;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;
use app\classes\FixJson;
use app\controller\Session\Cookie;
use app\classes\HttpFactory;
use Symfony\Component\DomCrawler\Crawler;

Class faltas extends Controller{

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
                    $faltas = $this->crawler->filter('input[name="GXState"]')->attr('value');  
                    
                    $json = FixJson::fix($faltas);
                    
                    $output = $this->trataJson(json_decode($json));
                    $this->response($output);
                }else{

                    $this->response(array(
                            "error" => 400,
                            "msg" => "Crie uma sessão com um usuário válido"
                    )); 

                }

    }

    public function Post(){



    }
    

    private function getContent($cookie){

        $http_client= new HttpFactory(
            "GET",
            "https://siga.cps.sp.gov.br/aluno/faltasparciais.aspx",
            null,
            null,
            $cookie
        );
        $response= $http_client->request();
        return $response->getBody()->getContents();
    }

    private function trataJson($dados){
        $jsonTratado = array();
        
        foreach($dados->vFALTAS as $faltas){

            $jsonTratado[] = array(

                "ID" => trim($faltas->ACD_DisciplinaSigla),
                "DESCRICAO" => trim($faltas->ACD_DisciplinaNome),
                "FALTAS" => (int) $faltas->TotalAusencias,
                "PRESENCAS" =>(int) $faltas->TotalPresencas,
                "TOTAL" => (int) $faltas->TotalAusencias + (int) $faltas->TotalPresencas
            );

        }

        
        return $jsonTratado;
    }

}