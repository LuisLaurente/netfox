<?php include 'views/templates/header.php'; ?>
<h2>Clientes</h2>
<a href="<?= url('cliente/create') ?>">➕ Nuevo Cliente</a>
<br><br>
<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Celular</th>
        <th>Costo</th>
        <th>Cuenta (Correo)</th>
        <th>Contraseña</th>
        <th>Tipo Cuenta</th>
        <th>Código Perfil</th>
        <th>Vencimiento Cliente</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($clientes as $cl): ?>
        <?php
        // Mostrar el código de perfil personalizado si existe, sino generar automático
        $codigoPerfil = $cl['codigo_cliente']
            ?: substr($cl['celular'], - ($cl['digitos_codigo'] ?? 4));
        ?>
        <tr>
            <td><?= $cl['id'] ?></td>
            <td><?= $cl['nombre'] ?></td>
            <td><?= $cl['celular'] ?></td>
            <td><?= $cl['costo'] ?> soles</td>
            <td><?= $cl['correo'] ?? '-' ?></td>
            <td><?= $cl['contrasena'] ?? '-' ?></td>
            <td><?= $cl['tipo_nombre'] ?? '-' ?></td>
            <td><?= $codigoPerfil ?></td>
            <td><?= $cl['fecha_vencimiento'] ?></td>
            <td>
                <button onclick="copiarDatos(
                    '<?= strtoupper($cl['tipo_nombre'] ?? '-') ?>',
                    '<?= $cl['nombre'] ?>',
                    '<?= $cl['costo'] ?>',
                    '<?= $cl['correo'] ?? '-' ?>',
                    '<?= $cl['contrasena'] ?? '-' ?>',
                    '<?= $codigoPerfil ?>',
                    '<?= $cl['fecha_vencimiento'] ?>'
                )">📋 Copiar</button> |
                <a href="<?= url('cliente/edit/' . $cl['id']) ?>">✏️ Editar</a> |
                <a href="<?= url('cliente/delete/' . $cl['id']) ?>" onclick="return confirm('¿Eliminar este cliente?')">🗑️ Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
    function copiarDatos(tipo, nombre, costo, correo, pass, codigo, venc) {
        let texto = `${tipo}\n${nombre} ${costo} soles\nCorreo: ${correo}\nContraseña: ${pass}\nCódigo de perfil: ${codigo}\nVencimiento: ${venc}`;
        navigator.clipboard.writeText(texto).then(() => {
            alert('Datos copiados al portapapeles');
        });
    }
</script>

<?php include 'views/templates/footer.php'; ?>
