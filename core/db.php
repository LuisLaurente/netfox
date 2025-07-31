<?php
// core/db.php

// Detectar entorno automáticamente
$isProduction = !in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:8080']) 
                && !str_contains($_SERVER['HTTP_HOST'], 'xampp');

// Configuración según el entorno
if ($isProduction) {
    // Producción (cPanel)
    $dbConfig = [
        'host' => 'TU_HOST_PRODUCCION',        // IP o dominio del servidor MySQL
        'dbname' => 'netfox_bd',               // Nombre de la BD en cPanel
        'username' => 'usuario_cpanel',        // Usuario MySQL en cPanel
        'password' => 'contraseña_cpanel',     // Contraseña MySQL en cPanel
        'port' => 3306
    ];
} else {
    // Desarrollo local (XAMPP)
    $dbConfig = [
        'host' => '127.0.0.1',
        'dbname' => 'netfox',                  // Nombre de BD local
        'username' => 'root',
        'password' => '',
        'port' => 3306
    ];
}

// Clase de conexión PDO
class Database {
    private static $instance = null;
    private $conn;

    private function __construct($config) {
        try {
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};port={$config['port']}";
            $this->conn = new PDO($dsn, $config['username'], $config['password']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("SET NAMES utf8mb4");
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public static function getInstance($config) {
        if (!self::$instance) {
            self::$instance = new Database($config);
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Inicializar conexión
$db = Database::getInstance($dbConfig)->getConnection();
