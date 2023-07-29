<?php
namespace app\controller\disciplinas;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;
use app\controller\Session\Cookie;
use app\classes\HttpFactory;
use Symfony\Component\DomCrawler\Crawler;

Class disciplinas extends Controller{

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
        
        if ($this->cookie->issetCookie()){

            
            
            $XML_HTML = $this->getContent($this->cookie->getCookie());
            $this->crawler->addHtmlContent($XML_HTML);
            $disciplinas = $this->crawler->filter('input[name="Grid4ContainerDataV"]')->attr('value');           
        
            $dados = $this->trataJson( json_decode($disciplinas));
            $this->response($dados);
        

        }else{
            $this->response(
                array(
                    "error" => 400,
                    "msg" => "Crie uma nova sessão com uma senha correta!"
                )
                );
        }
      


    }

    public function Post(){



    }
    

    private function getContent($cookie){

        $http_client= new HttpFactory(
            "GET",
            "https://siga.cps.sp.gov.br/aluno/notasparciais.aspx",
            null,
            null,
            $cookie
        );
        $response= $http_client->request();
        return $response->getBody()->getContents();
    }

    private function trataJson($dados){
        $jsonTratado = array();
        
        foreach($dados as $disciplina){
            $jsonTratado[] = array(
                "ID" => $disciplina[5],
                "NOME" => $disciplina[7],
                "Média Final" => (float) $disciplina[12],
                "Faltas" => (int) $disciplina[17],
                "Frequência" => (int) $disciplina[22]
            );
        }


        return $jsonTratado;
    }

}