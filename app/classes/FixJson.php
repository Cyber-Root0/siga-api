<?php
namespace app\classes;
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

class FixJson{
        
    public static function fix($string){


        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://jsonformatter.curiousconcept.com/process?=",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => http_build_query(array(
            "jsonfix" => "on",
            "jsontemplate" => "1",
            "data" => $string,
            
        )),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/x-www-form-urlencoded"
          ],
        ]);
        
        $response = curl_exec($curl);
        //echo $response;
        $data = json_decode($response);
        return $data->result->data;

    }
}