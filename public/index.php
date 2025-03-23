<?php
session_start();
require '../vendor/autoload.php';
require '../src/routes.php';

// Permite requisições de qualquer origem (não recomendado para produção)
header("Access-Control-Allow-Origin: *");

// Permite os métodos HTTP que serão usados (GET, POST, etc.)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Permite os cabeçalhos personalizados que serão enviados na requisição
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Define o tipo de conteúdo da resposta como JSON
header("Content-Type: application/json");

// Se a requisição for do tipo OPTIONS, finaliza o script (usado em pré-requisições CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}




$router->run( $router->routes );

