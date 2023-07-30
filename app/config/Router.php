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

//FALTAS
$this->get('/api/faltas/all', 'faltas\\faltas@get');

//NOTAS
$this->get('/api/notas/all', 'notas\\notas@get');

//HORARIOS
$this->get('/api/horarios/all', 'horarios\\horarios@get');

//PROFESSORES
$this->get('/api/professores/all', 'professores\\professores@get');

//Dados do Aluno
$this->get('/api/aluno/all', 'aluno\\aluno@get');




