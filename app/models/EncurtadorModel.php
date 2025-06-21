<?php
namespace App\models;

use Exception;
use PDO;

class EncurtadorModel
{
    private $conn;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function encurtarUrl($original_url)
    {
        if (empty($original_url) || !filter_var($original_url, FILTER_VALIDATE_URL)) {
            throw new Exception("Invalid URL provided.");
        }

        if ($this->urlExiste($original_url)) {
            throw new Exception("URL already exists.");
        }

        $shortened_Url = substr(md5(uniqid()), 0, 6);

        // Corrigido: o nome da coluna deve ser 'shortened_url' (tudo minúsculo e igual ao banco)
        $stmt = $this->conn->prepare("INSERT INTO urls (original_url, shortened_url) VALUES (:original_url, :shortened_url)");
        $stmt->bindParam(':original_url', $original_url);
        $stmt->bindParam(':shortened_url', $shortened_Url);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            throw new Exception("Error inserting URL: " . implode(", ", $stmt->errorInfo()));
        }
    }

    public function urlExiste($original_url) : bool
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM urls WHERE original_url = :original_url");
        $stmt->bindParam(':original_url', $original_url);

        if ($stmt->execute()) {
            return $stmt->fetchColumn() > 0;
        } else {
            throw new Exception("Error checking URL existence: " . implode(", ", $stmt->errorInfo()));
        }
    }
    

    public function obterUrlEncurtada($id)
    {
        // Corrigido: o nome da coluna deve ser 'shortened_url'
        $stmt = $this->conn->prepare("SELECT shortened_url FROM urls WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return $stmt->fetchColumn();
        } else {
            throw new Exception("Error fetching URL: " . implode(", ", $stmt->errorInfo()));
        }
    }

    public function listarUrls()
    {
        // Corrigido: o nome da coluna deve ser 'shortened_url'
        $stmt = $this->conn->prepare("SELECT id, shortened_url FROM urls");

        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Error listing URLs: " . implode(", ", $stmt->errorInfo()));
        }
    }

    public function deletarUrl($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM urls WHERE id = :id");
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return $stmt->rowCount() > 0;
        } else {
            throw new Exception("Error deleting URL: " . implode(", ", $stmt->errorInfo()));
        }
    }

}