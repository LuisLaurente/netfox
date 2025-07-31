<?php
require_once 'core/db.php';

class CuentaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance([])->getConnection();
    }

// Listar todas las cuentas con su tipo (sin clientes todavía)
public function getAll()
{
    $stmt = $this->db->query("
        SELECT c.*, 
               t.nombre AS tipo_nombre, 
               t.limite_clientes, 
               t.digitos_codigo
        FROM cuentas c
        INNER JOIN tipos_cuenta t ON c.tipo_id = t.id
        ORDER BY c.id DESC
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    // Obtener una cuenta por ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM cuentas WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nueva cuenta
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO cuentas (correo, contrasena, tipo_id, fecha_vencimiento, precio_actual)
                                    VALUES (:correo, :contrasena, :tipo_id, :fecha_vencimiento, :precio_actual)");
        return $stmt->execute($data);
    }

    // Actualizar cuenta
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE cuentas 
            SET correo=:correo, contrasena=:contrasena, tipo_id=:tipo_id, fecha_vencimiento=:fecha_vencimiento, precio_actual=:precio_actual 
            WHERE id=:id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    // Eliminar cuenta
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM cuentas WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
