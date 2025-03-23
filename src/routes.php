<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/novo', 'UsuariosController@add');
$router->get('/teste', 'UsuariosController@teste');
$router->get('/sobre', 'HomeController@sobre');

$router->get('/listar', 'HomeController@listarFilmes');
$router->get('/listar-Filme', 'HomeController@listarFilme');
$router->post('/cadastrar-Filme', 'HomeController@cadastrarFilme');

