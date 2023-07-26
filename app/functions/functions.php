<?php

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