<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */
namespace app\controller\planoensino;
use GuzzleHttp\Client;
 trait MethodPlans{

    public function GetAjaxKey($GXState){
	
        $package = json_decode($GXState);
        if (!empty($package->GX_AJAX_KEY)){
            return $package->GX_AJAX_KEY;
        }

        return false;
	
    }
    public function EncryptAjaxKey($key){
        $URL = GENEXUS_BYPASS."?".http_build_query($this->PackageKey($key));
        return $this->MakeRequest("GET", $URL, []);
            
    }
    private function GetPlan($json, $disciplina, $action_code, $cookie = null){

        $ajax_key = $this->GetAjaxKey($json);
        $bypass_key = $this->EncryptAjaxKey($ajax_key);
        $GXState = $this->GetGXState($disciplina, $action_code);
        $PLAN_URL = PLANO_ENSINO_URL."?$bypass_key";
        $plan = $this->MakeRequest("POST", $PLAN_URL, array(
            "GXState" => $GXState
        ), $cookie);
        
        return $plan;
    }

    private function MakeRequest(string $method, string $url,array $params = [], $cookie =null){
        $client = new Client();
        $response = $client->request($method, $url, [
            'form_params'    => $params,
            'headers' => [
                'gxajaxrequest' => '1', 
                'content-type' => 'application/x-www-form-urlencoded',
            ],
            'cookies' => $cookie,
        ]);
        $body = $response->getBody()->getContents();
        return $body;

    }

    private function GetGXState($disciplina, $action_code){

           $Gxstate = json_decode(file_get_contents( __DIR__.'/Helper/json.json'));
           $GxstateReplaced = $this->ReplaceParamGxstate($Gxstate, $disciplina, $action_code);
           return $GxstateReplaced;

    }

    private function ReplaceParamGxstate($content, $disciplina, $action){

        foreach( $content->W0008AV18Tabs_PARM as $key => $actions ){

            $webComponent = $content->W0008AV18Tabs_PARM[$key]->WebComponent;
            $content->W0008AV18Tabs_PARM[$key]->WebComponent = str_replace("disciplina", $disciplina, $webComponent);
        }

        $content->W0008HISTORYMANAGER_Hash = $action;
        $content->AV5SHOW_ACD_DisciplinaSigla = $disciplina;
        $content->W0008W0013 = str_replace("disciplina", $disciplina, $content->W0008W0013);
        $content->W0008W0013AV39SHOW_ACD_DisciplinaSigla_PARM = str_replace("disciplina", $disciplina, $content->W0008W0013AV39SHOW_ACD_DisciplinaSigla_PARM);
        $content->W0008W0013AV39SHOW_ACD_DisciplinaSigla = str_replace("disciplina", $disciplina, $content->W0008W0013AV39SHOW_ACD_DisciplinaSigla);
        $content->AV39SHOW_ACD_DisciplinaSigla = str_replace("disciplina", $disciplina, $content->AV39SHOW_ACD_DisciplinaSigla);

        return json_encode($content);
    }

    private function PackageKey(string $key){
        return array(
            "key" => $key,
        );
    }

 }