<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETFOX - Panel</title>

    <!-- CSS general -->
    <link rel="stylesheet" href="<?= url('public/css/base.css') ?>">

    <!-- CSS específico por vista -->
    <?php if (isset($css)): ?>
        <link rel="stylesheet" href="<?= url('public/css/' . $css) ?>">
    <?php endif; ?>
</head>
<body>
    <header style="background:#2c3e50; color:#fff; padding:10px;">
        <h1>NETFOX - Panel Administrativo</h1>
        <nav style="margin-top:10px;">
            <a href="<?= url('cliente/index') ?>" style="color:white; margin-right:15px;">Clientes</a>
            <a href="<?= url('cliente/vencidos') ?>" style="color:white; margin-right:15px;">Vencidos</a>
            <a href="<?= url('cuenta/index') ?>" style="color:white; margin-right:15px;">Cuentas</a>
            <a href="<?= url('tipocuenta/index') ?>" style="color:white;">Tipos de cuenta</a>
        </nav>
    </header>

    <main style="padding: 20px;">
