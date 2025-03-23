<?php

namespace src\controllers;

use \core\Controller;
use src\models\Filme;

class HomeController extends Controller {

    public function index() {
        $this->render('home');
    }
      

    
        public function listarFilme() {
            // Instancia a classe Test
            $testModel = new Filme();
    
            // Chama o método para consultar o banco de dados
            $filmes = $testModel->getFilmesFromDatabase();
    
            // Retorna os dados em formato JSON
            header('Content-Type: application/json');
            echo json_encode($filmes);
       
        }



        public function cadastrarFilme() {
            // Recebe os dados do formulário (supondo que sejam enviados via POST)
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        
            if (empty($titulo)) {
                echo json_encode(['status' => 'error', 'message' => 'O título do filme é obrigatório.']);
                return;
            }
        
            // Instancia a classe Test (ou Filmes, se preferir)
            $testModel = new Filme();
        
            // Insere o filme no banco de dados
            $result = $testModel->inserirFilme($titulo);
        
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Filme cadastrado com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar o filme.']);
            }
        }








 }    
