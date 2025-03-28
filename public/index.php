<?php
session_start();
require '../vendor/autoload.php';
require '../src/routes.php';

// Configurações de CORS (permitir requisições de qualquer origem)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

// Se a requisição for do tipo OPTIONS, finaliza o script (pré-requisições CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Extrai o método HTTP e a URI da requisição
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Instancia o HomeController
$homeController = new \src\controllers\HomeController();

// Roteamento manual para as requisições
switch (true) {
    // Rota principal (página inicial)
    case ($method === 'GET' && $uri === '/backend_filme/public/'):
        $homeController->index();
        break;

    // Listar filmes
    case ($method === 'GET' && $uri === '/backend_filme/public/listar-filme'):
        $homeController->listarFilmes();
        break;

    // Listar filmes por categoria
    case ($method === 'GET' && preg_match('/\/backend_filme\/public\/filmes\/categoria\/([\w]+)/', $uri, $matches)):
        $categoria = $matches[1]; // Extrai a categoria da URI
        $homeController->listarFilmesPorCategoria($categoria);
        break;

    // Listar categorias
    case ($method === 'GET' && $uri === '/backend_filme/public/listar-categorias'):
        $homeController->listarCategorias();
        break;

    // Cadastrar filme (com upload de imagem)
    case ($method === 'POST' && $uri === '/backend_filme/public/cadastrar-filme'):
        $homeController->cadastrarFilme(); // Agora o método lida com FormData
        break;

    // Buscar filme por ID
    case ($method === 'GET' && preg_match('/\/backend_filme\/public\/filme\/(\d+)/', $uri, $matches)):
        $id = $matches[1]; // Extrai o ID da URI
        $homeController->buscarFilme($id);
        break;

    // Deletar filme
    case ($method === 'DELETE' && preg_match('/\/backend_filme\/public\/deletar-filme\/(\d+)/', $uri, $matches)):
        $id = $matches[1]; // Extrai o ID da URI
        $homeController->deletarFilme($id);
        break;

    // Atualizar filme
    case ($method === 'PUT' && preg_match('/\/backend_filme\/public\/atualizar-filme\/(\d+)/', $uri, $matches)):
        $id = $matches[1]; // Extrai o ID da URI
        $homeController->atualizarFilme($id);
        break;

    // Rota não encontrada
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['status' => 'error', 'message' => 'Rota não encontrada.']);
        break;
}
?>