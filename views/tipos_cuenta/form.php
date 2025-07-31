<?php include 'views/templates/header.php'; ?>
<h2><?= isset($tipo) ? 'Editar Tipo de Cuenta' : 'Nuevo Tipo de Cuenta' ?></h2>

<form method="POST" action="<?= isset($tipo) ? url('tipocuenta/update/' . $tipo['id']) : url('tipocuenta/store') ?>">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" value="<?= $tipo['nombre'] ?? '' ?>" required><br><br>

    <label>Límite de clientes:</label><br>
    <input type="number" name="limite" value="<?= $tipo['limite_clientes'] ?? '' ?>" required><br><br>

    <label>Precio mensual:</label><br>
    <input type="number" step="0.01" name="precio_mensual" value="<?= $tipo['precio_mensual'] ?? '' ?>" required><br><br>

    <label>¿Cuántos dígitos usar para el código de perfil?</label><br>
    <input type="number" name="digitos_codigo" value="<?= $tipo['digitos_codigo'] ?? 4 ?>" min="1" max="10" required><br><br>

    <label>Precio especial (opcional):</label><br>
    <input type="number" step="0.01" name="precio_especial" value="<?= $tipo['precio_especial'] ?? '' ?>"><br><br>

    <label>
        <input type="checkbox" name="ciclo_especial" <?= isset($tipo) && $tipo['ciclo_especial'] ? 'checked' : '' ?>>
        ¿Ciclo especial (13 días)?
    </label><br><br>

    <button type="submit">💾 Guardar</button>
    <a href="<?= url('tipocuenta/index') ?>">Cancelar</a>
</form>
<?php include 'views/templates/footer.php'; ?>