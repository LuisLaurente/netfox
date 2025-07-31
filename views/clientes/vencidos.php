<?php include 'views/templates/header.php'; ?>
<link rel="stylesheet" href="<?= url('public/css/vencidos-clientes.css') ?>">

<h2>Clientes con cuentas vencidas</h2>

<!-- Filtro por días -->
<div style="margin-bottom: 15px;">
    <label>Filtrar por días vencidos:</label>
    <select id="filtroDias">
        <option value="0">Todos</option>
        <option value="1">Vencidos hoy</option>
        <option value="3">Hasta 3 días</option>
        <option value="7">Hasta 7 días</option>
        <option value="30">Hasta 30 días</option>
    </select>
</div>

<!-- Tabla de clientes vencidos -->
<table border="1" cellpadding="8" cellspacing="0" width="100%" id="tablaVencidos">
    <thead>
        <tr style="background:#2c3e50; color:white;">
            <th>Nombre</th>
            <th>Celular</th>
            <th>Tipo de Cuenta</th>
            <th>Costo</th>
            <th>Correo</th>
            <th>Contraseña</th>
            <th>Código Perfil</th>
            <th>Fecha Vencimiento</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($agrupados as $cliente): ?>
            <?php foreach ($cliente['cuentas'] as $cu): 
                // Calcular días vencidos
                $diasVencidos = floor((strtotime(date('Y-m-d')) - strtotime($cu['cliente_venc'])) / (60 * 60 * 24));

                // Color de la fila según días vencidos
                if ($diasVencidos == 0) {
                    $color = 'background:#fff3cd;'; // Amarillo
                } elseif ($diasVencidos == 1) {
                    $color = 'background:#ffe5b4;'; // Naranja claro
                } else {
                    $color = 'background:#f8d7da;'; // Rojo
                }
            ?>
                <tr style="<?= $color ?>">
                    <td><?= $cliente['nombre'] ?></td>
                    <td><?= $cliente['celular'] ?></td>
                    <td><?= $cu['tipo'] ?></td>
                    <td><strong><?= number_format($cu['costo'], 2) ?> soles</strong></td>
                    <td><?= $cu['correo'] ?></td>
                    <td><?= $cu['contrasena'] ?></td>
                    <td><?= $cu['codigo'] ?></td>
                    <td><strong><?= $cu['cliente_venc'] ?></strong></td>
                    <td>
                        <button onclick="copiarDatos(
                            '<?= strtoupper($cu['tipo']) ?>', 
                            '<?= $cliente['nombre'] ?>', 
                            '<?= $cu['costo'] ?>', 
                            '<?= $cu['correo'] ?>', 
                            '<?= $cu['contrasena'] ?>', 
                            '<?= $cu['codigo'] ?>', 
                            '<?= $cu['cliente_venc'] ?>'
                        )">📋 Copiar</button>
                        <a href="<?= url('cliente/edit/' . $cu['cliente_id']) ?>">✏️ Editar</a>
                        <a href="<?= url('cliente/delete/' . $cu['cliente_id']) ?>" onclick="return confirm('¿Eliminar este cliente?')">🗑️ Eliminar</a>
                        <a href="<?= url('cliente/renovar/' . $cu['cliente_id']) ?>" style="color:green;">➕ Renovar +1 mes</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    // Filtro por días vencidos
    document.getElementById('filtroDias').addEventListener('change', function() {
        let dias = parseInt(this.value);
        let hoy = new Date();

        document.querySelectorAll('#tablaVencidos tbody tr').forEach(fila => {
            let fecha = fila.cells[7].innerText;
            let venc = new Date(fecha);
            let diff = Math.floor((hoy - venc) / (1000 * 60 * 60 * 24));
            fila.style.display = (dias === 0 || diff <= dias) ? '' : 'none';
        });
    });

    // Función para copiar datos
    function copiarDatos(tipo, nombre, costo, correo, pass, codigo, venc) {
        let texto = `${tipo}\n${nombre} ${costo} soles\nCorreo: ${correo}\nContraseña: ${pass}\nCódigo de perfil: ${codigo}\nVencimiento: ${venc}`;
        navigator.clipboard.writeText(texto).then(() => alert('Datos copiados al portapapeles'));
    }
</script>

<?php include 'views/templates/footer.php'; ?>
