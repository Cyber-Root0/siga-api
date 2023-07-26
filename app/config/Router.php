<?php

$this->get('', function(){
    echo "Estou na area da home";
});
$this->get('/notas', 'Notas\\Notas@index');



