<?php

require_once "../includes/auth.php";
require_once "../includes/config.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location:index.php");
    exit();
}

$id = (int) $_GET["id"];

/*
|--------------------------------------------------------------------------
| Check if category is used in products
|--------------------------------------------------------------------------
*/

$check = $pdo->prepare("
SELECT COUNT(*)
FROM products
WHERE category_id = ?
");

$check->execute([$id]);
if ($check->fetchColumn() > 0) {
    header("Location:index.php?error=used");
    exit();
}

/*
|--------------------------------------------------------------------------
| Get Image
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
SELECT image
FROM categories
WHERE id=?
");

$stmt->execute([$id]);
$category = $stmt->fetch();
if (!$category) {
    header("Location:index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Delete Image
|--------------------------------------------------------------------------
*/

if (
    !empty($category["image"]) &&
    file_exists("../../uploads/categories/" . $category["image"])
) {
    unlink("../../uploads/categories/" . $category["image"]);
}

/*
|--------------------------------------------------------------------------
| Delete Record
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
DELETE
FROM categories
WHERE id=?
");

$stmt->execute([$id]);
header("Location:index.php?success=deleted");
exit();