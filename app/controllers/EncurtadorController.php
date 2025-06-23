<?php

namespace App\controllers;

use config\DatabaseConfig;
use Exception;
use App\models\EncurtadorModel;


class EncurtadorController
{
    private $db;

    public function __construct()
    {
        try {
            $this->db = DatabaseConfig::getConnection();
            if (!$this->db) {
                throw new Exception("Database connection failed.");
            }
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    }

    public function encurtarUrl($url)
    {
        try {
            $encurtadorModel = new EncurtadorModel($this->db);
            $id = $encurtadorModel->encurtarUrl($url);

            http_response_code(201);

            return json_encode(['success' => true, 'id' => $id, 'message' => 'URL shortened successfully.']);
        } catch (Exception $e) {
            http_response_code(400);

            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function listarUrls()
    {
        try {
            $encurtadorModel = new EncurtadorModel($this->db);
            $urls = $encurtadorModel->listarUrls();

            http_response_code(200);
            return json_encode(['success' => true, 'urls' => $urls]);
        } catch (Exception $e) {
            http_response_code(400);
            return json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function obterUrlEncurtada($id)
    {
        // Implementar lógica para obter URL encurtada
    }

    public function deletarUrl($id)
    {
        // Implementar lógica para deletar URL
    }
}
