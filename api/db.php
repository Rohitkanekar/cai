<?php

/*=========================================
    DATABASE CONFIGURATION
=========================================*/

$host = "localhost";
$dbname = "concrete_arts_india";
$username = "root";
$password = "";

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