<?php
require_once "includes/config.php";

$json = file_get_contents('products.json');
$products = json_decode($json, true);

/*
|--------------------------------------------------------------------------
| Load Products from Database
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM products
    ORDER BY id ASC
");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$products) {
    die("No products found in database.");
}

/*
|--------------------------------------------------------------------------
| Run Import Modules
|--------------------------------------------------------------------------
*/

require_once "import/products.php";
require_once "import/sizes.php";
require_once "import/features.php";
require_once "import/seo.php";
require_once "import/images.php";