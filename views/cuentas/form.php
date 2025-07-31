<?php include 'views/templates/header.php'; ?>
<h2><?= isset($cuenta) ? 'Editar Cuenta' : 'Nueva Cuenta' ?></h2>

<form method="POST" action="<?= isset($cuenta) ? url('cuenta/update/'.$cuenta['id']) : url('cuenta/store') ?>">
    <label>Tipo de Cuenta:</label><br>
    <select name="tipo_id" required>
        <?php foreach ($tipos as $t): ?>
            <option value="<?= $t['id'] ?>" <?= isset($cuenta) && $cuenta['tipo_id']==$t['id'] ? 'selected' : '' ?>>
                <?= $t['nombre'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Correo:</label><br>
    <input type="email" name="correo" value="<?= $cuenta['correo'] ?? '' ?>" required><br><br>

    <label>Contraseña:</label><br>
    <input type="text" name="contrasena" value="<?= $cuenta['contrasena'] ?? '' ?>" required><br><br>

    <label>Precio actual:</label><br>
    <input type="number" step="0.01" name="precio_actual" value="<?= $cuenta['precio_actual'] ?? '' ?>" required><br><br>

    <label>Fecha de vencimiento:</label><br>
    <input type="date" name="fecha_vencimiento" value="<?= $cuenta['fecha_vencimiento'] ?? '' ?>" required><br><br>

    <button type="submit">💾 Guardar</button>
    <a href="<?= url('cuenta/index') ?>">Cancelar</a>
</form>
<?php include 'views/templates/footer.php'; ?>
