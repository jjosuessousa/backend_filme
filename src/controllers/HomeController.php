<?php
namespace src\controllers;

use core\Controller;
use src\models\Filme;

class HomeController extends Controller {
    public function index() {
        $this->render('home');
    }

    public function listarFilmes() {
        $filmeModel = new Filme();
        $filmes = $filmeModel->getFilmesFromDatabase();

        header('Content-Type: application/json');
        echo json_encode($filmes);
    }

    public function cadastrarFilme() {
        $data = json_decode(file_get_contents('php://input'), true);
        $titulo = $data['titulo'];
        $sinopse = $data['sinopse'];
        $trailer = $data['trailer'];
        $capa = $data['capa'];
        $categoria = $data['categoria'];

        if (empty($titulo)) {
            echo json_encode(['status' => 'error', 'message' => 'O título do filme é obrigatório.']);
            return;
        }

        $filmeModel = new Filme();
        $result = $filmeModel->inserirFilme($titulo, $sinopse, $trailer, $capa, $categoria);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Filme cadastrado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o filme.']);
        }
    }

    public function deletarFilme($id) {
        $filmeModel = new Filme();
        $result = $filmeModel->deletarFilme($id);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Filme deletado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao deletar o filme.']);
        }
    }

    public function atualizarFilme($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $titulo = $data['titulo'];
        $sinopse = $data['sinopse'];
        $trailer = $data['trailer'];
        $capa = $data['capa'];
        $categoria = $data['categoria'];

        if (empty($titulo)) {
            echo json_encode(['status' => 'error', 'message' => 'O título do filme é obrigatório.']);
            return;
        }

        $filmeModel = new Filme();
        $result = $filmeModel->atualizarFilme($id, $titulo, $sinopse, $trailer, $capa, $categoria);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Filme atualizado com sucesso!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar o filme.']);
        }
    }
}