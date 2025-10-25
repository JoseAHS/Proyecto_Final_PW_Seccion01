<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/csrf.php';
require_once __DIR__ . '/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); // Verifica que el token CSRF sea válido

    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass  = $_POST['pass'] ?? '';

    if ($email === '' || $pass === '') {
        exit('Faltan campos');
    }

    try {
        $pdo = db();
        // Busca el usuario por email
        $stmt = $pdo->prepare('SELECT TOP (1) id, name, email, pass_hash FROM dbo.users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verifica contraseña
        if (!$user || !password_verify($pass, $user['pass_hash'])) {
            header('Location: /index.php?msg=credenciales_invalidas');
            exit;
        }

        // Si todo está bien, crea la sesión
        login_user($user);
        header('Location: /index.php'); // vuelve al index (zona privada)
        exit;

    } catch (PDOException $e) {
        http_response_code(500);
        echo '<h2>Error de conexión</h2>';
        echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
    }

} else {
    http_response_code(405);
    echo 'Método no permitido';
}
