<?php
require_once __DIR__ . '/db.php';

try {
    $pdo = db();
    $r = $pdo->query('SELECT 1 AS ok')->fetch();
    echo '<h2> Conexion exitosa a SQL Server</h2>';
    echo '<p>Resultado: ' . $r['ok'] . '</p>';
} catch (Throwable $e) {
    echo '<h2> Error de conexion</h2>';
    echo '<pre>' . $e->getMessage() . '</pre>';
}
?>
