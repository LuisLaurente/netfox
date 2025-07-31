<?php
// index.php

require_once 'core/db.php';
require_once 'core/helpers.php';

// Obtener URL limpia
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home/index';
$urlParts = explode('/', $url);

$controllerName = ucfirst($urlParts[0]) . 'Controller';
$method = $urlParts[1] ?? 'index';
$params = array_slice($urlParts, 2);

// Cargar controlador
$controllerPath = "controllers/$controllerName.php";

if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controller = new $controllerName();

    if (method_exists($controller, $method)) {
        call_user_func_array([$controller, $method], $params);
    } else {
        die("Método $method no encontrado en $controllerName");
    }
} else {
    die("Controlador $controllerName no encontrado");
}
