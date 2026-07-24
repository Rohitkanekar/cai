<?php

require_once "includes/config.php";

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