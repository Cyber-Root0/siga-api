<?php

//Doc
$this->get('', function(){
    echo "Estou na area da home";
});

//Session
$this->post('/api/session/create', 'Session\\Session@post');
$this->get('/api/session/refresh', 'Session\\Session@get');

//Notas


