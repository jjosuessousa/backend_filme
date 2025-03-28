<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/sobre', 'HomeController@sobre');





$router->post('/cadastrar-Filme', 'HomeController@cadastrarFilme');
$router->get('/listar-filme', 'HomeController@listarFilmes');
$router->delete('/deletar-filme/{id}', 'HomeController@deletarFilme');
$router->put('/atualizar-filme/{id}', 'HomeController@atualizarFilme');
$router->get('/filme/{id}', 'HomeController@buscarFilme');
$router->get('/filme/ListarCategorias', 'HomeController@ListarCategorias');

