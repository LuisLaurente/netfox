<?php include 'views/templates/header.php'; ?>
<h2>Tipos de Cuenta</h2>
<a href="<?= url('tipocuenta/create') ?>">➕ Nuevo Tipo de Cuenta</a>
<br><br>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Límite</th>
        <th>Precio Mensual</th>
        <th>Precio Especial</th>
        <th>Ciclo Especial</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($tipos as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $t['nombre'] ?></td>
        <td><?= $t['limite_clientes'] ?></td>
        <td><?= $t['precio_mensual'] ?></td>
        <td><?= $t['precio_especial'] ?: '-' ?></td>
        <td><?= $t['ciclo_especial'] ? 'Sí' : 'No' ?></td>
        <td>
            <a href="<?= url('tipocuenta/edit/'.$t['id']) ?>">✏️ Editar</a> |
            <a href="<?= url('tipocuenta/delete/'.$t['id']) ?>" onclick="return confirm('¿Eliminar este tipo de cuenta?')">🗑️ Eliminar</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
<?php include 'views/templates/footer.php'; ?>
