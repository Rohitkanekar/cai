<?php

require_once "../includes/config.php";
require_once "../includes/header.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Validate ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    header("Location:index.php");

    exit;

}

$product_id = (int) $_GET["id"];

/*
|--------------------------------------------------------------------------
| Product
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

/*
|--------------------------------------------------------------------------
| Thumbnail
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
SELECT *
FROM product_images
WHERE product_id=?
AND is_thumbnail=1
LIMIT 1
");

$stmt->execute([$product_id]);

$thumbnail = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Product Sizes
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM product_sizes
    WHERE product_id=?
    ORDER BY FIELD
    (
        size,
        'Large',
        'Medium',
        'Small',
        'Extra Small'
    )
");

$stmt->execute([$id]);

$productSizes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Default Row
|--------------------------------------------------------------------------
*/

if (empty($productSizes)) {

    $productSizes[] = [

        "size" => "Large",

        "length_mm" => "",
        "length_inch" => "",

        "height_mm" => "",
        "height_inch" => "",

        "breadth_mm" => "",
        "breadth_inch" => "",

        "price" => ""

    ];

}

/*
|--------------------------------------------------------------------------
| Features
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
SELECT *
FROM product_features
WHERE product_id=?
ORDER BY id ASC
");

$stmt->execute([$product_id]);

$productFeatures = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
SELECT *
FROM product_seo
WHERE product_id=?
LIMIT 1
");

$stmt->execute([$product_id]);

$productSEO = $stmt->fetch(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT id, name
    FROM categories
    WHERE status = 1
    ORDER BY sort_order ASC, name ASC
");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>Edit Product</h2>

            <small class="text-muted">

                Update product information

            </small>

        </div>

        <a href="index.php" class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>

    <form action="update.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $product['id'] ?>">

        <?php require_once "includes/form.php"; ?>

    </form>

</div>

<?php require_once "../includes/footer.php"; ?>