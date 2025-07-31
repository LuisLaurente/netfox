<?php
class HomeController {
    public function index() {
        echo "<h1>Bienvenido a NETFOX</h1>";
        echo "<a href='" . url('home/saludo/Luis') . "'>Ir a saludo</a>";
    }

    public function saludo($nombre = 'Invitado') {
        echo "<h2>Hola, $nombre 👋</h2>";
        echo "<a href='" . url() . "'>Volver al inicio</a>";
    }
}
