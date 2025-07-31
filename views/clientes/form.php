<?php include 'views/templates/header.php'; ?>
<h2><?= isset($cliente) ? 'Editar Cliente' : 'Nuevo Cliente' ?></h2>

<form method="POST" action="<?= isset($cliente) ? url('cliente/update/'.$cliente['id']) : url('cliente/store') ?>">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= $cliente['nombre'] ?? '' ?>" required><br><br>

    <label>Celular:</label><br>
    <input type="text" name="celular" value="<?= $cliente['celular'] ?? '' ?>" required><br><br>

    <label>Costo (S/):</label><br>
    <input type="number" step="0.01" name="costo" value="<?= $cliente['costo'] ?? '' ?>" required><br><br>

    <label>Cuenta asociada:</label><br>
    <select name="cuenta_id" id="cuenta_id" required>
        <option value="">Seleccione una cuenta</option>
        <?php foreach ($cuentas as $c): ?>
            <option value="<?= $c['id'] ?>" data-digitos="<?= $c['digitos_codigo'] ?>"
                <?= isset($cliente) && $cliente['cuenta_id'] == $c['id'] ? 'selected' : '' ?>>
                <?= $c['tipo_nombre'] ?> - <?= $c['correo'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <!-- Checkbox para generar código automáticamente -->
    <label>
        <input type="checkbox" name="auto_codigo" id="auto_codigo" 
            <?= empty($cliente['codigo_cliente']) ? 'checked' : '' ?>>
        Generar código automáticamente (últimos dígitos del celular)
    </label><br><br>

    <!-- Campo para código manual -->
    <div id="codigo_manual" style="display: <?= empty($cliente['codigo_cliente']) ? 'none' : 'block' ?>;">
        <label>Código de perfil personalizado:</label><br>
        <input type="text" 
               name="codigo_cliente" 
               id="codigo_cliente"
               value="<?= $cliente['codigo_cliente'] ?? '' ?>"
               maxlength="<?= $cuentas[0]['digitos_codigo'] ?? 4 ?>">
    </div><br>

    <label>Fecha de vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento" value="<?= $cliente['fecha_vencimiento'] ?? '' ?>" required><br><br>

    <button type="submit">💾 Guardar</button>
    <a href="<?= url('cliente/index') ?>">Cancelar</a>
</form>

<script>
    // Mostrar u ocultar el campo de código manual según el checkbox
    document.getElementById('auto_codigo').addEventListener('change', function() {
        document.getElementById('codigo_manual').style.display = this.checked ? 'none' : 'block';
    });

    // Ajustar maxlength del código manual según la cuenta seleccionada
    document.getElementById('cuenta_id').addEventListener('change', function() {
        let digitos = this.selectedOptions[0].getAttribute('data-digitos') || 4;
        document.getElementById('codigo_cliente').setAttribute('maxlength', digitos);
    });
</script>

<?php include 'views/templates/footer.php'; ?>
