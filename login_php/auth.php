<?php
require_once __DIR__ . '/db.php';

function require_auth(): void {
    start_session();
    if (empty($_SESSION['user'])) {
        header('Location: /index.php?msg=login_requerido');
        exit;
    }
}

function login_user(array $user): void {
    start_session();
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
    ];
}

function logout_user(): void {
    start_session();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
