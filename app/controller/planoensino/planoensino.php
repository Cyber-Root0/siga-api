<?php

/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

namespace app\controller\planoensino;
use app\core\Controller;
use app\interfaces\ControllerInterface;
use app\classes\Input;
use app\classes\FixJson;
use app\controller\Session\Cookie;
use app\classes\HttpFactory;
use Symfony\Component\DomCrawler\Crawler;

Class planoensino extends Controller{
    use MethodPlans;
    public $uid = null;
    public $disciplina = null;
    protected $header = "Content-Type:text/html; charset=utf-8";
    protected $http_client = null;

    protected Crawler $crawler;

    protected string $action_code = "1";

    public function index(){

    }

    public function __construct(){

        $this->uid = Input::get("uid");
        $this->disciplina = Input::get("disciplina");
        $this->crawler = new Crawler;
        parent::__construct();
    }

    public function get(){
        
       
        if ($this->status_cookie && !empty($this->disciplina)){

            $XML_HTML = $this->getContent($this->cookie->getCookie());
            $this->crawler->addHtmlContent($XML_HTML);
            $notas = $this->crawler->filter('input[name="GXState"]')->attr('value');  
            $json = $this->fixJson($notas);
            
            $content =  $this->GetPlan($json, $this->disciplina, $this->action_code, $this->cookie->getCookie());
            $content = $this->fixJson($content);
            $output = $this->trataJson(json_decode($content));
            $this->response($output);
        }else{

            $this->response(array(
                    "error" => 400,
                    "msg" => "Crie uma sessão com um usuário válido"
            )); 

        }

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

    public function Post(){



    }
    

    private function trataJson($dados){
          
        $out = array(
            "EMENTA" => $dados->gxValues[3]->AV24ACD_DisciplinaEmenta,
            "OBJETIVOS" => $dados->gxValues[3]->AV30ACD_DisciplinaObjetivo,
            "CARGAS" => array(
                "semanal" => (int) $dados->gxValues[3]->AV31ACD_DisciplinaAulasSemanais,
                "teoricas" => (int) $dados->gxValues[3]->AV32ACD_DisciplinaAulasTeoricas,
                "praticas" => (int) $dados->gxValues[3]->AV33ACD_DisciplinaAulasPraticas,
                "total" => (int) $dados->gxValues[3]->AV34ACD_DisciplinaAulasTotaisPeriodo
            )
            );

        return $out;
    }

}