<?php
require_once 'models/TipoCuentaModel.php';

class TipoCuentaController {
    private $model;

    public function __construct() {
        $this->model = new TipoCuentaModel();
    }

    // Listar tipos de cuenta
    public function index() {
        $tipos = $this->model->getAll();
        require 'views/tipos_cuenta/index.php';
    }

    // Mostrar formulario de creación
    public function create() {
        require 'views/tipos_cuenta/form.php';
    }

    // Guardar nuevo tipo
    public function store() {
        $data = [
            'nombre' => sanitize($_POST['nombre']),
            'limite' => (int)$_POST['limite'],
            'precio_mensual' => (float)$_POST['precio_mensual'],
            'precio_especial' => $_POST['precio_especial'] !== '' ? (float)$_POST['precio_especial'] : null,
            'ciclo' => isset($_POST['ciclo_especial']) ? 1 : 0,
            'digitos_codigo' => (int)$_POST['digitos_codigo'],
            'color' => $_POST['color'] ?? '#3498db' // ✅ Aquí agregamos el color

        ];
        $this->model->create($data);
        redirect(url('tipocuenta/index'));
    }

    // Editar tipo existente
    public function edit($id) {
        $tipo = $this->model->getById($id);
        require 'views/tipos_cuenta/form.php';
    }

    // Actualizar tipo de cuenta
    public function update($id) {
        $data = [
            'nombre' => sanitize($_POST['nombre']),
            'limite' => (int)$_POST['limite'],
            'precio_mensual' => (float)$_POST['precio_mensual'],
            'precio_especial' => $_POST['precio_especial'] !== '' ? (float)$_POST['precio_especial'] : null,
            'ciclo' => isset($_POST['ciclo_especial']) ? 1 : 0,
            'digitos_codigo' => (int)$_POST['digitos_codigo'],
            'color' => $_POST['color'] ?? '#3498db' // ✅ Aquí agregamos el color

        ];
        $this->model->update($id, $data);
        redirect(url('tipocuenta/index'));
    }

    // Eliminar tipo de cuenta
    public function delete($id) {
        $this->model->delete($id);
        redirect(url('tipocuenta/index'));
    }
}
