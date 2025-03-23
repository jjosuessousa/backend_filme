<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/novo', 'UsuariosController@add');
$router->get('/teste', 'UsuariosController@teste');
$router->get('/sobre', 'HomeController@sobre');

$router->get('/listar', 'HomeController@listarFilmes');

$router->post('/cadastrar-Filme', 'HomeController@cadastrarFilme');
$router->get('/listar-filme', 'HomeController@listarFilmes');
$router->delete('/deletar-filme/{id}', 'HomeController@deletarFilme');
$router->put('/atualizar-filme/{id}', 'HomeController@atualizarFilme');

