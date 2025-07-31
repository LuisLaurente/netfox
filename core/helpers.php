<?php
function url($path = '') {
    // Detectar entorno automáticamente
    $isProduction = !in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:8080']) 
                    && !str_contains($_SERVER['HTTP_HOST'], 'xampp');

    if ($isProduction) {
        // Dominio en producción
        $baseUrl = 'https://tudominio.com/NETFOX/'; 
    } else {
        // Local en XAMPP
        $baseUrl = 'http://localhost/NETFOX/'; 
    }

    return $baseUrl . ltrim($path, '/');
}

// Redirigir a otra URL dentro del proyecto
function redirect($url) {
    header("Location: $url");
    exit;
}

// Limpiar texto recibido (evita inyecciones y XSS)
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}
