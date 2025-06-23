<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\controllers\{
    EncurtadorController
};

$routes = [
    'encurtarUrl' => [EncurtadorController::class, 'encurtarUrl'],
    'listarUrls' => [EncurtadorController::class, 'listarUrls'],
    'redirecionar' => [EncurtadorController::class, 'redirecionar'],
];

$uri = trim(parse_url($_SERVER['PATH_INFO'], PHP_URL_PATH), '/');

if (array_key_exists($uri, $routes)) {

    if (isset($routes[$uri]) && is_array($routes[$uri])){
        $controller = $routes[$uri][0];
        $method = $routes[$uri][1];

        $controller = new $controller();

        if (method_exists($controller, $method)) {
            http_response_code(200);
            $data = call_user_func([$controller, $method], $_REQUEST);
            
            if (is_array($data)) {
                echo json_encode($data);
            } else {
                echo $data;
            }

        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Method not found']);
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Controller not found']);
    }

}

