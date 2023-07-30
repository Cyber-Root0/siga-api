<?php
/*
 * @software API for the Siga Student System | Fatec
 * @author Bruno Venancio Alves <boteistem@gmail.com>
 * @copyrigh (c) 2023 
 * @license  Open Software License v. 3.0 (OSL-3.0)
 */

function dd($params = [],$die = true){
    echo '<pre>';
    print_r($params);
    echo '</pre>';
    if ($die) die();
}

//sanitização dos parametros quando entram no sistema
function getParams($id){
   return filter_var($_GET[$id], FILTER_SANITIZE_STRING);
}