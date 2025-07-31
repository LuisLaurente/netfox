<?php include 'views/templates/header.php'; ?>
<h2>Cuentas</h2>
<a href="<?= url('cuenta/create') ?>">➕ Nueva Cuenta</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tipo de Cuenta</th>
        <th>Límite de clientes</th>
        <th>Correo</th>
        <th>Contraseña</th>
        <th>Precio Actual</th>
        <th>Número de dígitos código</th>
        <th>Vencimiento</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($cuentas as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['tipo_nombre'] ?></td>
            <td><?= $c['limite_clientes'] ?></td>
            <td><?= $c['correo'] ?></td>
            <td><?= $c['contrasena'] ?></td>
            <td><?= $c['precio_actual'] ?></td>
            <td><?= $c['digitos_codigo'] ?></td>
            <td><?= $c['fecha_vencimiento'] ?></td>
            <td>
                <a href="<?= url('cuenta/edit/' . $c['id']) ?>">✏️ Editar</a> |
                <a href="<?= url('cuenta/delete/' . $c['id']) ?>" onclick="return confirm('¿Eliminar esta cuenta?')">🗑️ Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php include 'views/templates/footer.php'; ?>
