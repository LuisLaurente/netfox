<?php
require_once 'core/db.php';

class TipoCuentaModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance([])->getConnection();
    }

    // Listar todos los tipos de cuenta
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM tipos_cuenta ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un tipo de cuenta por ID
    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tipos_cuenta WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
        INSERT INTO tipos_cuenta (nombre, limite_clientes, precio_mensual, precio_especial, ciclo_especial, digitos_codigo) 
        VALUES (:nombre, :limite, :precio_mensual, :precio_especial, :ciclo, :digitos_codigo)
    ");
        return $stmt->execute($data);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
        UPDATE tipos_cuenta 
        SET nombre=:nombre, limite_clientes=:limite, precio_mensual=:precio_mensual, precio_especial=:precio_especial, ciclo_especial=:ciclo, digitos_codigo=:digitos_codigo
        WHERE id=:id
    ");
        $data['id'] = $id;
        return $stmt->execute($data);
    }


    // Eliminar tipo de cuenta
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM tipos_cuenta WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
