<?php
require_once 'models/ClienteModel.php';
require_once 'models/CuentaModel.php';

class ClienteController
{
    private $model;
    private $cuentaModel;

    public function __construct()
    {
        $this->model = new ClienteModel();
        $this->cuentaModel = new CuentaModel();
    }

    public function index()
    {
        $clientes = $this->model->getAll();
        require 'views/clientes/index.php';
    }

    public function create()
    {
        $cuentas = $this->cuentaModel->getAll();
        require 'views/clientes/form.php';
    }

    public function store()
    {
        $codigo = isset($_POST['auto_codigo'])
            ? null  // Automático: no guardamos nada
            : sanitize($_POST['codigo_cliente']); // Manual: guardamos valor

        $data = [
            'nombre' => sanitize($_POST['nombre']),
            'codigo_cliente' => $codigo,
            'celular' => sanitize($_POST['celular']),
            'costo' => (float)$_POST['costo'],
            'fecha_vencimiento' => $_POST['fecha_vencimiento'],
            'cuenta_id' => (int)$_POST['cuenta_id']
        ];
        $this->model->create($data);
        redirect(url('cliente/index'));
    }

    public function edit($id)
    {
        $cliente = $this->model->getById($id);
        $cuentas = $this->cuentaModel->getAll();
        require 'views/clientes/form.php';
    }

    public function update($id)
    {
        $codigo = isset($_POST['auto_codigo'])
            ? null
            : sanitize($_POST['codigo_cliente']);

        $data = [
            'nombre' => sanitize($_POST['nombre']),
            'codigo_cliente' => $codigo,
            'celular' => sanitize($_POST['celular']),
            'costo' => (float)$_POST['costo'],
            'fecha_vencimiento' => $_POST['fecha_vencimiento'],
            'cuenta_id' => (int)$_POST['cuenta_id']
        ];
        $this->model->update($id, $data);
        redirect(url('cliente/index'));
    }

    public function delete($id)
    {
        $this->model->delete($id);
        redirect(url('cliente/index'));
    }
}
