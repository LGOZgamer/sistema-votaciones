<?php
require 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $contrasena = $_POST['contrasena'] ?? '';
    $stmt = $pdo->prepare('SELECT u.*, r.nombre_rol FROM usuarios u INNER JOIN roles r ON u.id_rol=r.id_rol WHERE u.correo=? AND u.estado="Activo" LIMIT 1');
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch();
    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario'] = $usuario['nombre'];
        $_SESSION['correo'] = $usuario['correo'];
        $_SESSION['rol'] = $usuario['nombre_rol'];
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Correo o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login - Sistema de Votaciones</title><link rel="stylesheet" href="assets/style.css"></head><body class="login-body">
<div class="login-card">
  <img src="assets/logo_votacion.svg" alt="Logo votación">
  <h1>Sistema de Votaciones</h1>
  <p class="muted">Ingreso seguro al sistema</p>
  <?php if($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <form method="POST">
    <input type="email" name="correo" placeholder="Correo" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit" style="width:100%;margin-top:10px">Ingresar</button>
  </form>
  <p class="muted">Demo: admin@votaciones.com / admin123</p>
</div>
</body></html>
