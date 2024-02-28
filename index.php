<?php
// index.php

// 1. Configuración de la base de datos
require_once './app/config/Database.php';

// 2. Create instances of controllers
require_once __DIR__ . '/app/controllers/PostController.php';
$controller = new PostController();

require_once __DIR__ . '/app/controllers/AuthController.php';
$authController = new AuthController();

// 3. Analiza la URL para obtener la ruta y los parámetros
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$query   = $_SERVER['QUERY_STRING'];

// 4. Routing
switch ($request) {
    case '/blog/':
        $controller->index();
        break;
    case '/blog/create':
        // Página para crear un nuevo post
        $controller->create();
        break;
    case '/blog/edit':
        // Página para editar un post existente, esperando un id como parámetro
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $controller->edit($_GET['id']);
        } else {
            echo "ID del post no especificado para la edición.";
        }
        break;
    case '/blog/post':
        // Acción para guardar (crear o actualizar) un post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $controller->save();
        } else if (isset($_GET['id']) && !empty($_GET['id'])) {
            // Mostrar un post específico si se proporciona un id
            $controller->show($_GET['id']);
        } else {
            $controller->index();
        }
        break;
    case '/blog/delete':
        // Acción para eliminar un post, esperando un id como parámetro
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            echo "ID del post no especificado para eliminar.";
        }
        break;

    // New cases for authentication
    case '/blog/login':
        $authController->login();
        break;

    case '/blog/login/authenticate':
        $authController->authenticate();
        break;


    default:
        // Página 404
        http_response_code(404);
        require __DIR__ . '/app/views/404.php';
        exit; // Make sure to exit to prevent further execution
}
