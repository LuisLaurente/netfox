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
        $data = $this->model->getAll();
        $cuentasAgrupadas = [];

        foreach ($data as $row) {
            $cuentaId = $row['cuenta_id'];
            if (!isset($cuentasAgrupadas[$cuentaId])) {
                $cuentasAgrupadas[$cuentaId] = [
                    'id' => $row['cuenta_id'],
                    'correo' => $row['correo'],
                    'contrasena' => $row['contrasena'],
                    'cuenta_venc' => $row['cuenta_venc'],
                    'tipo_nombre' => $row['tipo_nombre'],
                    'digitos_codigo' => $row['digitos_codigo'],
                    'color' => $row['color'] ?? '#3498db', // ✅ Aquí debe asignarse
                    'clientes' => []
                ];
            }
            if ($row['cliente_id']) {
                $cuentasAgrupadas[$cuentaId]['clientes'][] = [
                    'id' => $row['cliente_id'],
                    'nombre' => $row['cliente_nombre'],
                    'celular' => $row['celular'],
                    'costo' => $row['costo'],
                    'codigo_cliente' => $row['codigo_cliente'],
                    'cliente_venc' => $row['cliente_venc']
                ];
            }
        }

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
    public function vencidos()
    {
        $clientesVencidos = $this->model->getVencidos();

        // Agrupar vencidos por cliente
        $agrupados = [];
        foreach ($clientesVencidos as $c) {
            $id = $c['cliente_id'];
            if (!isset($agrupados[$id])) {
                $agrupados[$id] = [
                    'nombre' => $c['cliente_nombre'],
                    'celular' => $c['celular'],
                    'cuentas' => []
                ];
            }
            $agrupados[$id]['cuentas'][] = [
                'cliente_id' => $c['cliente_id'], // ✅ corregido
                'tipo' => $c['tipo_nombre'],
                'correo' => $c['correo'],
                'contrasena' => $c['contrasena'],
                'codigo' => $c['codigo_cliente'] ?: substr($c['celular'], -$c['digitos_codigo']),
                'costo' => $c['costo'], // ✅ añadimos el costo
                'cliente_venc' => $c['cliente_venc']
            ];
        }

        require 'views/clientes/vencidos.php';
    }
    public function renovar($id)
    {
        $this->model->renovarMes($id);
        redirect(url('cliente/vencidos'));
    }
}
