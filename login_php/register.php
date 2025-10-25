<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/csrf.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check();

    $name  = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $pass  = $_POST['pass'] ?? '';
    $pass2 = $_POST['pass2'] ?? '';

    if ($name === '' || $email === '' || $pass === '' || $pass2 === '') {
        exit('faltan campos');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('email invalido');
    }
    if (strlen($pass) < 8) {
        exit('pass muy corta');
    }
    if ($pass !== $pass2) {
        exit('pass no coincide');
    }

    $pdo = db();
    $stmt = $pdo->prepare('SELECT TOP (1) id FROM dbo.users WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        exit('email ya registrado');
    }

    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $ins = $pdo->prepare('INSERT INTO dbo.users (name, email, pass_hash) VALUES (?, ?, ?)');
    $ins->execute([$name, $email, $hash]);

    header('Location: /index.php?msg=registrado');
    exit;
}

http_response_code(405);
echo 'metodo no permitido';
