<?php include 'views/templates/header.php'; ?>
<link rel="stylesheet" href="<?= url('public/css/index-clientes.css') ?>">

<h2>Clientes agrupados por cuenta</h2>

<!-- Botón para añadir nuevo cliente -->
<div style="margin-bottom: 15px;">
    <a href="<?= url('cliente/create') ?>" 
       style="display:inline-block; padding:8px 12px; background:#28a745; color:#fff; text-decoration:none; border-radius:4px;">
        ➕ Nuevo Cliente
    </a>
</div>

<!-- Barra de búsqueda -->
<div style="margin-top:10px; margin-bottom:15px;">
    <input type="text" id="buscar" placeholder="Buscar cliente por nombre o celular..." style="width: 300px; padding: 5px;">
</div>

<!-- Botones de filtro -->
<div>
    <button onclick="filtrar('Todos')">Todos</button>
    <?php foreach (array_unique(array_column($cuentasAgrupadas, 'tipo_nombre')) as $tipo): ?>
        <button onclick="filtrar('<?= $tipo ?>')"><?= $tipo ?></button>
    <?php endforeach; ?>
</div>
<br>

<!-- Bloques de cuentas -->
<div id="contenedor">
    <?php foreach ($cuentasAgrupadas as $cuenta): 
        $color = $cuenta['color'] ?? '#3498db'; // Color por defecto si no está definido
    ?>
        <div class="cuenta-bloque"
            data-tipo="<?= $cuenta['tipo_nombre'] ?>"
            style="
                border-left: 6px solid <?= $color ?>;
                padding: 10px;
                margin-bottom: 15px;
                background: #fff;
                border-radius: 8px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            ">
            
            <h3 style="color: <?= $color ?>;">
                <?= strtoupper($cuenta['tipo_nombre']) ?> - <?= $cuenta['correo'] ?>
            </h3>
            <p><strong>Contraseña:</strong> <?= $cuenta['contrasena'] ?> |
                <strong>Vence:</strong> <?= $cuenta['cuenta_venc'] ?>
            </p>
            <hr>
            <?php if (!empty($cuenta['clientes'])): ?>
                <ul>
                    <?php foreach ($cuenta['clientes'] as $cli):
                        $codigoPerfil = $cli['codigo_cliente'] ?: substr($cli['celular'], -$cuenta['digitos_codigo']);
                    ?>
                        <li>
                            <?= $cli['nombre'] ?> (S/<?= $cli['costo'] ?>) | Cel: <?= $cli['celular'] ?> |
                            Código: <?= $codigoPerfil ?> | Vence: <?= $cli['cliente_venc'] ?>
                            <button onclick="copiarDatos('<?= strtoupper($cuenta['tipo_nombre']) ?>', '<?= $cli['nombre'] ?>', '<?= $cli['costo'] ?>', '<?= $cuenta['correo'] ?>', '<?= $cuenta['contrasena'] ?>', '<?= $codigoPerfil ?>', '<?= $cli['cliente_venc'] ?>')">📋 Copiar</button>

                            <!-- Botón Editar -->
                            <a href="<?= url('cliente/edit/' . $cli['id']) ?>" 
                               style="margin-left:5px; padding:3px 6px; background:#ffc107; color:#000; text-decoration:none; border-radius:4px;">
                                ✏️ Editar
                            </a>

                            <!-- Botón Eliminar -->
                            <a href="<?= url('cliente/delete/' . $cli['id']) ?>" 
                               onclick="return confirm('¿Estás seguro de eliminar este cliente?')" 
                               style="margin-left:5px; padding:3px 6px; background:#dc3545; color:#fff; text-decoration:none; border-radius:4px;">
                                🗑️ Eliminar
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p><em>Sin clientes asignados.</em></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function filtrar(tipo) {
        document.querySelectorAll('.cuenta-bloque').forEach(bloque => {
            if (tipo === 'Todos' || bloque.dataset.tipo === tipo) {
                bloque.style.display = 'block';
            } else {
                bloque.style.display = 'none';
            }
        });
    }

    function copiarDatos(tipo, nombre, costo, correo, pass, codigo, venc) {
        let texto = `${tipo}\n${nombre} ${costo} soles\nCorreo: ${correo}\nContraseña: ${pass}\nCódigo de perfil: ${codigo}\nVencimiento: ${venc}`;
        navigator.clipboard.writeText(texto).then(() => alert('Datos copiados al portapapeles'));
    }

    document.getElementById('buscar').addEventListener('keyup', function() {
        let query = this.value.toLowerCase();

        document.querySelectorAll('.cuenta-bloque').forEach(bloque => {
            let clientes = bloque.querySelectorAll('ul li');
            let hayCoincidencia = false;

            clientes.forEach(cli => {
                let texto = cli.textContent.toLowerCase();
                if (texto.includes(query)) {
                    cli.style.display = 'list-item';
                    hayCoincidencia = true;
                } else {
                    cli.style.display = 'none';
                }
            });

            bloque.style.display = hayCoincidencia ? 'block' : 'none';
        });
    });
</script>

<?php include 'views/templates/footer.php'; ?>
