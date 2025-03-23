<?php
namespace src\models;

use core\Database;
use core\Model;
use PDO;
use PDOException;

class Filme extends Model {
    public function getFilmesFromDatabase() {
        $sql = "SELECT id, titulo, sinopse, trailer, capa, categoria FROM filmes";

        try {
            $pdo = Database::getInstance();
            $result = $pdo->query($sql);

            if ($result && $result->rowCount() > 0) {
                $filmes = $result->fetchAll(PDO::FETCH_ASSOC);

                // Adiciona o caminho completo das imagens
                foreach ($filmes as &$filme) {
                    $filme['capa'] = 'http://localhost/backend_filme/uploads/' . $filme['capa'];
                }

                return $filmes;
            } else {
                return [];
            }
        } catch (PDOException $e) {
            die("Erro na consulta ao banco de dados: " . $e->getMessage());
        }
    }

    public function inserirFilme($titulo, $sinopse, $trailer, $capa, $categoria) {
        $sql = "INSERT INTO filmes (titulo, sinopse, trailer, capa, categoria) VALUES (:titulo, :sinopse, :trailer, :capa, :categoria)";
    
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindValue(':sinopse', $sinopse, PDO::PARAM_STR);
            $stmt->bindValue(':trailer', $trailer, PDO::PARAM_STR);
            $stmt->bindValue(':capa', $capa, PDO::PARAM_STR);
            $stmt->bindValue(':categoria', $categoria, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar filme: " . $e->getMessage());
            return false;
        }
    }

    public function deletarFilme($id) {
        $sql = "DELETE FROM filmes WHERE id = :id";
    
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0; // Retorna true se alguma linha foi deletada
        } catch (PDOException $e) {
            error_log("Erro ao deletar filme: " . $e->getMessage());
            return false;
        }
    }

    public function buscarFilmePorId($id) {
        $sql = "SELECT * FROM filmes WHERE id = :id";
    
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna os dados do filme
        } catch (PDOException $e) {
            error_log("Erro ao buscar filme: " . $e->getMessage());
            return false;
        }
    }

    public function atualizarFilme($id, $titulo, $sinopse, $trailer, $capa, $categoria) {
        $sql = "UPDATE filmes SET titulo = :titulo, sinopse = :sinopse, trailer = :trailer, capa = :capa, categoria = :categoria WHERE id = :id";

        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->bindValue(':sinopse', $sinopse, PDO::PARAM_STR);
            $stmt->bindValue(':trailer', $trailer, PDO::PARAM_STR);
            $stmt->bindValue(':capa', $capa, PDO::PARAM_STR);
            $stmt->bindValue(':categoria', $categoria, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao atualizar filme: " . $e->getMessage());
        }
    }
}