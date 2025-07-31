<?php
require_once 'models/CuentaModel.php';
require_once 'models/TipoCuentaModel.php';

class CuentaController {
    private $model;
    private $tipoModel;

    public function __construct() {
        $this->model = new CuentaModel();
        $this->tipoModel = new TipoCuentaModel();
    }

    public function index() {
        $cuentas = $this->model->getAll();
        require 'views/cuentas/index.php';
    }

    public function create() {
        $tipos = $this->tipoModel->getAll();
        require 'views/cuentas/form.php';
    }

    public function store() {
        $data = [
            'correo' => sanitize($_POST['correo']),
            'contrasena' => sanitize($_POST['contrasena']),
            'tipo_id' => (int)$_POST['tipo_id'],
            'fecha_vencimiento' => $_POST['fecha_vencimiento'],
            'precio_actual' => (float)$_POST['precio_actual']
        ];
        $this->model->create($data);
        redirect(url('cuenta/index'));
    }

    public function edit($id) {
        $cuenta = $this->model->getById($id);
        $tipos = $this->tipoModel->getAll();
        require 'views/cuentas/form.php';
    }

    public function update($id) {
        $data = [
            'correo' => sanitize($_POST['correo']),
            'contrasena' => sanitize($_POST['contrasena']),
            'tipo_id' => (int)$_POST['tipo_id'],
            'fecha_vencimiento' => $_POST['fecha_vencimiento'],
            'precio_actual' => (float)$_POST['precio_actual']
        ];
        $this->model->update($id, $data);
        redirect(url('cuenta/index'));
    }

    public function delete($id) {
        $this->model->delete($id);
        redirect(url('cuenta/index'));
    }
}
