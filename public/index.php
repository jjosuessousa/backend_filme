<?php 
session_start();
require '../vendor/autoload.php';
require '../src/routes.php';

// Configurações de CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json");

// Pré-requisições CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Extrai método e URI
$method = $_SERVER['REQUEST_METHOD'];
$uri = rawurldecode($_SERVER['REQUEST_URI']); // Decodifica a URI

// Log para debug (remova em produção)
error_log("Requisição recebida: $method $uri");

// Instancia o Controller
$homeController = new \src\controllers\HomeController();

// Roteamento
switch (true) {
    // Rota principal
    case ($method === 'GET' && $uri === '/backend_filme/public/'):
        $homeController->index();
        break;

    // Listar filmes
    case ($method === 'GET' && $uri === '/backend_filme/public/listar-filme'):
        $homeController->listarFilmes();
        break;

    // Listar filmes por categoria
    case ($method === 'GET' && preg_match('%^/backend_filme/public/filmes/categoria/([^/]+)$%i', $uri, $matches)):
        $categoria = rawurldecode($matches[1]);
        $homeController->listarFilmesPorCategoria($categoria);
        break;

    // Buscar filme por título
    case ($method === 'GET' && preg_match('%^/backend_filme/public/filmes/titulo/(.+)$%', $uri, $matches)):
        $titulo = rawurldecode($matches[1]);
        $homeController->buscarFilmePorTitulo($titulo);
        break;

    // Listar categorias
    case ($method === 'GET' && $uri === '/backend_filme/public/categorias'):
        $homeController->listarCategorias();
        break;

    // Cadastrar filme
    case ($method === 'POST' && $uri === '/backend_filme/public/cadastrar-filme'):
        $homeController->cadastrarFilme();
        break;

    // Buscar filme por ID
    case ($method === 'GET' && preg_match('%^/backend_filme/public/filme/(\d+)$%', $uri, $matches)):
        $id = (int)$matches[1];
        $homeController->buscarFilme($id);
        break;

    // Deletar filme
    case ($method === 'DELETE' && preg_match('%^/backend_filme/public/deletar-filme/(\d+)$%', $uri, $matches)):
        $id = (int)$matches[1];
        $homeController->deletarFilme($id);
        break;

    // Atualizar filme
    case ($method === 'PUT' && preg_match('%^/backend_filme/public/atualizar-filme/(\d+)$%', $uri, $matches)):
        $id = (int)$matches[1];
        $homeController->atualizarFilme($id);
        break;

    // Rota não encontrada
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode([
            'status' => 'error',
            'message' => 'Rota não encontrada',
            'requested_uri' => $uri,
            'available_routes' => [
                '/backend_filme/public/',
                '/backend_filme/public/categorias',
                '/backend_filme/public/filmes/categoria/{categoria}',
                '/backend_filme/public/listar-filme',
                '/backend_filme/public/filme/{id}',
                '/backend_filme/public/filmes/titulo/{titulo}',
                '/backend_filme/public/cadastrar-filme',
                '/backend_filme/public/deletar-filme/{id}',
                '/backend_filme/public/atualizar-filme/{id}'
            ]
        ]);
        break;
}
