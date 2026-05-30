<?php verificarSesion(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Votaciones</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="topbar">
  <div class="brand">
    <img src="assets/logo_votacion.svg" alt="Logo votación">
    <span>Sistema de Votaciones</span>
  </div>
  <div class="userbar"><?= e($_SESSION['usuario']) ?> | <?= e($_SESSION['rol']) ?> | <a href="logout.php">Salir</a></div>
</nav>
<aside class="sidebar">
  <a href="index.php">Inicio</a>
  <?php if (puedeVerModulo('votaciones')): ?><a href="votaciones.php">Votaciones</a><?php endif; ?>
  <?php if (puedeVerModulo('mesas')): ?><a href="mesas.php">Mesas</a><?php endif; ?>
  <?php if (puedeVerModulo('candidatos')): ?><a href="candidatos.php">Candidatos</a><?php endif; ?>
  <?php if (puedeVerModulo('resultados')): ?><a href="resultados.php">Registrar resultados</a><?php endif; ?>
  <?php if (puedeVerModulo('reportes')): ?><a href="reportes.php">Consultar resultados</a><?php endif; ?>
  <?php if (puedeVerModulo('usuarios')): ?><a href="usuarios.php">Usuarios</a><?php endif; ?>
  <?php if (puedeVerModulo('roles')): ?><a href="roles.php">Roles</a><?php endif; ?>
</aside>
<main class="content">
