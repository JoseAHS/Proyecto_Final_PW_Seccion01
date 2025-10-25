<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/csrf.php';

start_session();
$csrf = csrf_token();
$u = $_SESSION['user'] ?? null;
$msg = $_GET['msg'] ?? '';
?>
<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>index</title></head>
<body>

<?php if ($u): ?>
  <!-- zona privada -->
  <h1>hola <?php echo htmlspecialchars($u['name']); ?></h1>
  <p>sesion con <?php echo htmlspecialchars($u['email']); ?></p>
  <p><a href="/logout.php">cerrar sesion</a></p>

<?php else: ?>
  <!-- zona publica: login y registro -->
  <?php if ($msg): ?><p><strong><?php echo htmlspecialchars($msg); ?></strong></p><?php endif; ?>

  <h2>iniciar sesion</h2>
  <form method="post" action="/login.php" autocomplete="off">
    <input type="hidden" name="csrf" value="<?php echo $csrf; ?>">
    <label>email</label><input type="email" name="email" required>
    <label>pass</label><input type="password" name="pass" required>
    <button type="submit">entrar</button>
  </form>

  <hr>

  <h2>registrar</h2>
  <form method="post" action="/register.php" autocomplete="off">
    <input type="hidden" name="csrf" value="<?php echo $csrf; ?>">
    <label>nombre</label><input type="text" name="name" required>
    <label>email</label><input type="email" name="email" required>
    <label>pass</label><input type="password" name="pass" minlength="8" required>
    <label>repetir pass</label><input type="password" name="pass2" minlength="8" required>
    <button type="submit">crear cuenta</button>
  </form>
<?php endif; ?>

</body>
</html>
