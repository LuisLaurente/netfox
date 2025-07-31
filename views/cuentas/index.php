<?php include 'views/templates/header.php'; ?>
<h2>Cuentas</h2>
<a href="<?= url('cuenta/create') ?>">➕ Nueva Cuenta</a>
<br><br>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tipo de Cuenta</th>
        <th>Límite</th>
        <th>Correo</th>
        <th>Contraseña</th>
        <th>Precio Actual</th>
        <th>Dígitos Código</th>
        <th>Vencimiento</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($cuentas as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['tipo_nombre'] ?></td>
            <td><?= $c['limite_clientes'] ?></td> <!-- Desde tipos_cuenta -->
            <td><?= $c['correo'] ?></td>
            <td><?= $c['contrasena'] ?></td>
            <td><?= $c['precio_actual'] ?></td> <!-- Precio actual correcto -->
            <td><?= $c['digitos_codigo'] ?></td> <!-- Nuevo: dígitos de código perfil -->
            <td><?= $c['fecha_vencimiento'] ?></td>
            <td>
                <button onclick="copiarDatos(
                    '<?= strtoupper($c['tipo_nombre']) ?>', 
                    '<?= $c['correo'] ?>', 
                    '<?= $c['contrasena'] ?>', 
                    '<?= $c['precio_actual'] ?>', 
                    '<?= $c['fecha_vencimiento'] ?>',
                    <?= $c['digitos_codigo'] ?>
                )">
                    📋 Copiar
                </button> |
                <a href="<?= url('cuenta/edit/' . $c['id']) ?>">✏️ Editar</a> |
                <a href="<?= url('cuenta/delete/' . $c['id']) ?>" onclick="return confirm('¿Eliminar esta cuenta?')">🗑️ Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
    function copiarDatos(tipo, correo, pass, precio, venc, digitos) {
        let codigoPerfil = '-'; // Temporal: hasta integrar clientes
        let texto = `${tipo}\n${precio} soles\nCorreo: ${correo}\nContraseña: ${pass}\nCódigo de perfil: ${codigoPerfil}\nVencimiento: ${venc}`;
        navigator.clipboard.writeText(texto).then(() => {
            alert('Datos copiados al portapapeles');
        });
    }
</script>

<?php include 'views/templates/footer.php'; ?>
