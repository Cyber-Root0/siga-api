<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */


namespace app\classes;
class CPF{
    public const estados = array(
        "AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA",
        "MT", "MS", "MG", "PA", "PB", "PR", "PE", "PI", "RJ", "RN",
        "RS", "RO", "RR", "SC", "SP", "SE", "TO"
    );
    public static function validaCPF($cpf) {
 
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    
    }

    public static function validaRG($login_rg){
        //extract numbers
        $numbers_rg = preg_replace( '/[^0-9]/is', '', $login_rg );
        //extract text, after number
        $suffix = str_replace($numbers_rg, "",$login_rg);

        if (strlen($numbers_rg<10) && in_array(strtoupper($suffix), self::estados) ){
            return true;
        }else{
            return false;
        }
    }

    public static function validaRA($ra){
        // Extrai somente os números
        $ra = preg_replace( '/[^0-9]/is', '', $ra );
        if (strlen($ra) > 14) {
            return false;
        }else{
            return true;
        }

    }
}