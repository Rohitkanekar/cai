<?php
require_once "../includes/config.php";
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location:index.php");
    exit;
}
$product_id = (int) $_GET["id"];

/*
|--------------------------------------------------------------------------
| Check Product
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE id=?
");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    header("Location:index.php");
    exit;
}
try {
    $pdo->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Delete Images From Disk
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT image
        FROM product_images
        WHERE product_id=?
    ");
    $stmt->execute([$product_id]);
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($images as $image) {
        if (
            !empty($image["image"]) &&
            file_exists("../../" . $image["image"])
        ) {
            unlink("../../" . $image["image"]);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Product Images
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        DELETE FROM product_images
        WHERE product_id=?
    ");
    $stmt->execute([$product_id]);

    /*
    |--------------------------------------------------------------------------
    | Delete Product Sizes
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        DELETE FROM product_sizes
        WHERE product_id=?
    ");
    $stmt->execute([$product_id]);

    /*
    |--------------------------------------------------------------------------
    | Delete Product Features
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        DELETE FROM product_features
        WHERE product_id=?
    ");
    $stmt->execute([$product_id]);

    /*
    |--------------------------------------------------------------------------
    | Delete SEO
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        DELETE FROM product_seo
        WHERE product_id=?
    ");
    $stmt->execute([$product_id]);

    /*
    |--------------------------------------------------------------------------
    | Delete Product
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        DELETE FROM products
        WHERE id=?
    ");
    $stmt->execute([$product_id]);
    $pdo->commit();
    header("Location:index.php?deleted=1");
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    die($e->getMessage());
}