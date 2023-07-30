<?php
namespace app\controller\aluno;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;
use app\classes\FixJson;
use app\controller\Session\Cookie;
use app\classes\HttpFactory;
use Symfony\Component\DomCrawler\Crawler;

Class aluno extends Controller{

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
                    $aluno = $this->crawler->filter('input[name="GXState"]')->attr('value'); 
                    $aluno =  $this->fixJson($aluno);
                    $output = $this->trataJson(json_decode($aluno));
                    //$this->response($output);
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
            "https://siga.cps.sp.gov.br/aluno/horario.aspx.aspx",
            null,
            null,
            $cookie
        );
        $response= $http_client->request();
        return $response->getBody()->getContents();
    }

    private function trataJson($dados){
        $jsonTratado = array();
        
        $jsonTratado["NOME"] = $dados->MPW0041vPRO_PESSOALNOME;
        $jsonTratado["REGISTRO_ACADEMICO"] = $dados->MPW0041vACD_ALUNOCURSOREGISTROACADEMICOCURSO;
        $jsonTratado["EMAIL"] = $dados->MPW0041vINSTITUCIONALFATEC;
        $jsonTratado["FATEC_UNIDADE"] = $dados->vUNI_UNIDADENOME_MPAGE;
        $jsonTratado["CURSO"] = $dados->vACD_CURSONOME_MPAGE;
        $jsonTratado["TURNO"] = $dados->vACD_PERIODODESCRICAO_MPAGE;
       
        echo json_encode($jsonTratado);
        //return $jsonTratado;
    }

}