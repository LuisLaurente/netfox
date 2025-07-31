<?php
require_once 'core/db.php';

class ClienteModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance([])->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("
            SELECT cl.*, 
                   c.correo, c.contrasena, c.precio_actual, c.fecha_vencimiento AS cuenta_vencimiento,
                   t.nombre AS tipo_nombre, t.digitos_codigo
            FROM clientes cl
            LEFT JOIN cuentas c ON cl.cuenta_id = c.id
            LEFT JOIN tipos_cuenta t ON c.tipo_id = t.id
            ORDER BY cl.fecha_vencimiento ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO clientes (nombre, codigo_cliente, celular, costo, fecha_vencimiento, cuenta_id)
            VALUES (:nombre, :codigo_cliente, :celular, :costo, :fecha_vencimiento, :cuenta_id)
        ");
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE clientes 
            SET nombre=:nombre, codigo_cliente=:codigo_cliente, celular=:celular, costo=:costo, 
                fecha_vencimiento=:fecha_vencimiento, cuenta_id=:cuenta_id
            WHERE id=:id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
