<?php

namespace src\models;

use core\Database;
use core\Model;
use PDO;
use PDOException;

class Filme extends Model {
    public function getFilmesFromDatabase() {
        // Consulta SQL
        $sql = "SELECT id, titulo FROM filmes";

        try {
            // Obtém a instância do PDO usando a classe Database
            $pdo = Database::getInstance();

            // Executa a consulta
            $result = $pdo->query($sql);

            // Verifica se a consulta retornou dados
            if ($result && $result->rowCount() > 0) {
                return $result->fetchAll(PDO::FETCH_ASSOC); // Retorna os dados como um array associativo
            } else {
                return []; // Retorna um array vazio se não houver dados
            }
        } catch (PDOException $e) {
            // Captura e exibe erros do PDO
            die("Erro na consulta ao banco de dados: " . $e->getMessage());
        }
    }

    public function inserirFilme($titulo) {
        $sql = "INSERT INTO filmes (titulo) VALUES (:titulo)";
    
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao inserir filme: " . $e->getMessage());
        }
    }












}



