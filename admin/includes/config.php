<?php

$isLocal = (
    $_SERVER['HTTP_HOST'] === 'localhost' ||
    strpos($_SERVER['HTTP_HOST'], 'localhost:') === 0
);

if ($isLocal) {
    $host = "localhost";
    $dbname = "concrete_arts_india";
    $username = "root";
    $password = "";
    define('ADMIN_URL', '/cai/admin/');
} else {
    $host = "localhost";
    $dbname = "u699767164_concreteart";
    $username = "u699767164_concreteart";
    $password = "Concreteart@2026";
    define('ADMIN_URL', 'admin/');
}
try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed : " . $e->getMessage());
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}