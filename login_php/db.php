<?php
require_once __DIR__ . '/config.php';

function db(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        
        $dsn = 'sqlsrv:Server=' . DB_HOST . ';Database=' . DB_NAME . ';Encrypt=yes;TrustServerCertificate=yes';

        $opts = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,          
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     
        ];

        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
        } catch (PDOException $e) {
            http_response_code(500);
            echo '<h2>Error de conexion</h2>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . '</pre>';
            exit;
        }
    }

    return $pdo;
}

function start_session(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_name(SESSION_NAME);
        session_start();
    }
}

