<?php
require_once 'core/db.php';

class ClienteModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance([])->getConnection();
    }

    public function getAll()
    {
        $stmt = $this->db->query("
        SELECT 
            c.id AS cuenta_id,
            c.correo,
            c.contrasena,
            c.fecha_vencimiento AS cuenta_venc,
            t.nombre AS tipo_nombre,
            t.digitos_codigo,
            t.color,  -- ✅ Asegúrate de traer el color aquí
            cl.id AS cliente_id,
            cl.nombre AS cliente_nombre,
            cl.celular,
            cl.costo,
            cl.codigo_cliente,
            cl.fecha_vencimiento AS cliente_venc
        FROM cuentas c
        INNER JOIN tipos_cuenta t ON c.tipo_id = t.id
        LEFT JOIN clientes cl ON cl.cuenta_id = c.id
        ORDER BY c.id DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM clientes WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO clientes (nombre, codigo_cliente, celular, costo, fecha_vencimiento, cuenta_id)
            VALUES (:nombre, :codigo_cliente, :celular, :costo, :fecha_vencimiento, :cuenta_id)
        ");
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE clientes 
            SET nombre=:nombre, codigo_cliente=:codigo_cliente, celular=:celular, costo=:costo, 
                fecha_vencimiento=:fecha_vencimiento, cuenta_id=:cuenta_id
            WHERE id=:id
        ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM clientes WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
    public function getVencidos()
    {
        $stmt = $this->db->query("
        SELECT 
            cl.id AS cliente_id,
            cl.nombre AS cliente_nombre,
            cl.celular,
            cl.codigo_cliente,
            cl.costo,
            cl.fecha_vencimiento AS cliente_venc,
            cu.correo,
            cu.contrasena,
            cu.fecha_vencimiento AS cuenta_venc,
            tc.nombre AS tipo_nombre,
            tc.color,
            tc.digitos_codigo
        FROM clientes cl
        INNER JOIN cuentas cu ON cl.cuenta_id = cu.id
        INNER JOIN tipos_cuenta tc ON cu.tipo_id = tc.id
        WHERE cl.fecha_vencimiento <= CURDATE()
        ORDER BY cl.fecha_vencimiento ASC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function renovarMes($id)
    {
        $stmt = $this->db->prepare("UPDATE clientes SET fecha_vencimiento = DATE_ADD(fecha_vencimiento, INTERVAL 1 MONTH) WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
