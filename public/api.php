<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\controllers\EncurtadorController;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($data['url'])) {
    $controller = new EncurtadorController();
    echo $controller->encurtarUrl($data['url']);
    exit;
}

echo json_encode(['error' => 'Invalid request']);
exit;