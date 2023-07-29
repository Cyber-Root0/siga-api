<?php

//Doc
$this->get('', function(){
    echo "Estou na area da home";
});

//Session
$this->post('/api/session/create', 'Session\\Session@post');
$this->post('/api/session/delete', 'Session\\Session@deleteSession');

//Disciplinas
$this->get('/api/disciplinas/all', 'disciplinas\\disciplinas@get');

