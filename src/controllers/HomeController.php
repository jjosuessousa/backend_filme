<?php 
namespace src\controllers;

use core\Controller;
use src\models\Filme;

class HomeController extends Controller {

    // Rota principal (página inicial)
    public function index() {
        echo json_encode(['message' => 'Bem-vindo ao backend de filmes!']);
    }

    // Listar filmes por categoria
    public function listarFilmesPorCategoria($categoria) {
        $filmeModel = new Filme();
        $filmes = $filmeModel->getFilmesFromDatabase($categoria);

        header('Content-Type: application/json');
        echo json_encode($filmes);
    }

    // Listar todas as categorias
    public function listarCategorias() {
        $categorias = ["Ação", "Terror", "Drama", "Ficção", "Romance"]; // Exemplos de categorias fixas
        header('Content-Type: application/json');
        echo json_encode($categorias);
    }

    // Listar todos os filmes
    public function listarFilmes() {
        $filmeModel = new Filme();
        $filmes = $filmeModel->getFilmesFromDatabase();

        header('Content-Type: application/json');
        echo json_encode($filmes);
    }

    // Cadastrar filme (com upload de imagem)
    public function cadastrarFilme() {
        header('Content-Type: application/json'); // Garante que a resposta seja JSON

        // Verifica se o arquivo de imagem foi enviado
        if (!isset($_FILES['capa'])) {
            echo json_encode(['status' => 'error', 'message' => 'A capa do filme é obrigatória.']);
            return;
        }

        // Dados do formulário
        $titulo = $_POST['titulo'];
        $sinopse = $_POST['sinopse'];
        $trailer = $_POST['trailer'];
        $categoria = $_POST['categoria'];

        // Processa o upload da imagem
        $capa = $_FILES['capa'];
        $uploadDir = __DIR__ . '/../../uploads/'; // Caminho da pasta de uploads
        $uploadFile = $uploadDir . basename($capa['name']);

        // Verifica se o arquivo é uma imagem válida
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Formato de imagem inválido. Use JPG, JPEG, PNG ou GIF.']);
            return;
        }

        // Move o arquivo para a pasta de uploads
        if (move_uploaded_file($capa['tmp_name'], $uploadFile)) {
            // Salva o caminho da imagem no banco de dados
            $filmeModel = new Filme();
            $result = $filmeModel->inserirFilme(
                $titulo,
                $sinopse,
                $trailer,
                basename($capa['name']), // Salva apenas o nome do arquivo
                $categoria
            );

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Filme cadastrado com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o filme.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao fazer upload da imagem.']);
        }
    }

    // Deletar filme
    public function deletarFilme($id) {
        header('Content-Type: application/json'); // Garante que a resposta seja JSON

        if (!is_numeric($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID inválido.']);
            return;
        }

        $filmeModel = new Filme();
        $result = $filmeModel->deletarFilme($id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Filme deletado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Filme não encontrado ou já deletado.']);
        }
    }

    // Atualizar filme
    public function atualizarFilme($id) {
        header('Content-Type: application/json'); // Garante que a resposta seja JSON

        // Verifica se o título foi enviado
        if (empty($_POST['titulo'])) {
            echo json_encode(['status' => 'error', 'message' => 'O título do filme é obrigatório.']);
            return;
        }

        // Dados do formulário
        $titulo = $_POST['titulo'];
        $sinopse = $_POST['sinopse'];
        $trailer = $_POST['trailer'];
        $categoria = $_POST['categoria'];

        // Processa o upload da imagem (se uma nova imagem foi enviada)
        $capa = null;
        if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
            $capa = $_FILES['capa'];
            $uploadDir = __DIR__ . '/../../uploads/'; // Caminho da pasta de uploads
            $uploadFile = $uploadDir . basename($capa['name']);

            // Verifica se o arquivo é uma imagem válida
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($imageFileType, $allowedTypes)) {
                echo json_encode(['status' => 'error', 'message' => 'Formato de imagem inválido. Use JPG, JPEG, PNG ou GIF.']);
                return;
            }

            // Move o arquivo para a pasta de uploads
            if (!move_uploaded_file($capa['tmp_name'], $uploadFile)) {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao fazer upload da imagem.']);
                return;
            }

            $capa = basename($capa['name']); // Salva apenas o nome do arquivo
        }

        // Atualiza o filme no banco de dados
        $filmeModel = new Filme();
        $result = $filmeModel->atualizarFilme(
            $id,
            $titulo,
            $sinopse,
            $trailer,
            $capa, // Pode ser null se nenhuma nova imagem foi enviada
            $categoria
        );

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Filme atualizado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o filme.']);
        }
    }

    // Buscar filme por ID
    public function buscarFilme($id) {
        header('Content-Type: application/json'); // Garante que a resposta seja JSON

        if (!is_numeric($id)) {
            echo json_encode(['status' => 'error', 'message' => 'ID inválido.']);
            return;
        }

        $filmeModel = new Filme();
        $filme = $filmeModel->buscarFilmePorId($id);

        if ($filme) {
            echo json_encode($filme);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Filme não encontrado.']);
        }
    }
}

