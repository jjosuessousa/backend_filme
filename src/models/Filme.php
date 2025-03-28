<?php
namespace src\models;

use core\Database;
use core\Model;
use PDO;
use PDOException;

class Filme extends Model {
    public function getFilmesFromDatabase($categoria = null) {
        $sql = "SELECT id, titulo, sinopse, trailer, capa, categoria FROM filmes";
        if ($categoria) {
            $sql .= " WHERE categoria = :categoria";
        }

        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare($sql);

            if ($categoria) {
                $stmt->bindValue(':categoria', $categoria, PDO::PARAM_STR);
            }

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            return $stmt->rowCount() > 0;
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
            $filme = $stmt->fetch(PDO::FETCH_ASSOC);

            // Adiciona o caminho completo da imagem
            if ($filme) {
                $filme['capa'] = 'http://localhost/backend_filme/uploads/' . $filme['capa'];
            }
    
            return $filme;
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