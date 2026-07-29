<?php

require_once "../includes/auth.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: index.php");
    exit();
}

$id = (int) $_GET["id"];

try {
    $stmt = $pdo->prepare("
        DELETE FROM enquiries
        WHERE id = ?
    ");
    $stmt->execute([$id]);
    header("Location: index.php?success=deleted");
    exit();

} catch (PDOException $e) {
    header("Location: index.php?error=delete_failed");
    exit();
}