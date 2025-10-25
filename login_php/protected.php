<?php
require_once __DIR__ . '/auth.php';
require_auth();
start_session();
$user = $_SESSION['user'];
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>zona protegida</title>
</head>
<body>
  <h1>Hola <?php echo htmlspecialchars($user['name']); ?></h1>
  <p>Iniciaste sesión con <?php echo htmlspecialchars($user['email']); ?></p>
  <a href="/logout.php">Cerrar sesión</a>
</body>
</html>
