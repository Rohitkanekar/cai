<?php

/*=========================================
    DATABASE CONFIGURATION
=========================================*/

$host = "ftp.concreteartsindia.in";
$dbname = "u699767164_concreteart";
$username = "u699767164_concreteart";
$password = "Concreteart@2026";

/*=========================================
    PDO CONNECTION
=========================================*/

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [

            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode([
        "success" => false,
        "message" => "Database Connection Failed",
        "error" => $e->getMessage()
    ]));
}