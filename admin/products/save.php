<?php

require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Basic Fields
|--------------------------------------------------------------------------
*/

$category_id = (int) $_POST["category_id"];
$name = trim($_POST["name"]);
$slug = trim($_POST["slug"]);
$sku = trim($_POST["sku"]);
$item_code = trim($_POST["item_code"]);
$catalog = trim($_POST["catalog"]);
$series = trim($_POST["series"]);
$description = trim($_POST["description"]);
$material = trim($_POST["material"]);
$shape = trim($_POST["shape"]);
$finish = trim($_POST["finish"]);
$color = trim($_POST["color"]);

$featured = isset($_POST["featured"]) ? 1 : 0;
$status = isset($_POST["status"]) ? 1 : 0;

/*
|--------------------------------------------------------------------------
| Check Duplicate Slug
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM products
    WHERE slug=?
");

$stmt->execute([$slug]);

if ($stmt->fetch()) {

    die("Slug already exists.");

}

/*
|--------------------------------------------------------------------------
| Insert Product
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
INSERT INTO products
(
    category_id,
    name,
    slug,
    sku,
    item_code,
    catalog,
    series,
    description,
    material,
    shape,
    finish,
    color,
    featured,
    status
)
VALUES
(
    ?,?,?,?,?,?,?,?,?,?,?,?,?,?
)
");

$stmt->execute([

    $category_id,
    $name,
    $slug,
    $sku,
    $item_code,
    $catalog,
    $series,
    $description,
    $material,
    $shape,
    $finish,
    $color,
    $featured,
    $status

]);

$product_id = $pdo->lastInsertId();

/*
|--------------------------------------------------------------------------
| Save Product Sizes
|--------------------------------------------------------------------------
*/


if (!empty($_POST["size"])) {

    $stmt = $pdo->prepare("
        INSERT INTO product_sizes
        (
            product_id,
            size,
            length_mm,
            length_inch,
            height_mm,
            height_inch,
            breadth_mm,
            breadth_inch,
            price
        )
        VALUES
        (
            ?,?,?,?,?,?,?,?,?
        )
    ");

    foreach ($_POST["size"] as $index => $sizeName) {

        $sizeName = trim($sizeName);

        if ($sizeName === "") {
            continue;
        }

        $stmt->execute([

            $product_id,

            $sizeName,

            $_POST["length_mm"][$index] ?? 0,
            $_POST["length_inch"][$index] ?? 0,

            $_POST["height_mm"][$index] ?? 0,
            $_POST["height_inch"][$index] ?? 0,

            $_POST["breadth_mm"][$index] ?? 0,
            $_POST["breadth_inch"][$index] ?? 0,

            $_POST["price"][$index] ?? 0

        ]);

    }

}

/*
|--------------------------------------------------------------------------
| Upload Thumbnail
|--------------------------------------------------------------------------
*/

if (
    isset($_FILES["thumbnail"]) &&
    $_FILES["thumbnail"]["error"] == 0
) {

    $uploadDir = "../../uploads/products/";

    if (!is_dir($uploadDir)) {

        mkdir($uploadDir, 0777, true);

    }

    $extension = strtolower(
        pathinfo(
            $_FILES["thumbnail"]["name"],
            PATHINFO_EXTENSION
        )
    );

    $filename = uniqid() . "." . $extension;

    move_uploaded_file(

        $_FILES["thumbnail"]["tmp_name"],

        $uploadDir . $filename

    );

    $imagePath = "uploads/products/" . $filename;

    $stmt = $pdo->prepare("
        INSERT INTO product_images
        (
            product_id,
            image,
            alt_text,
            is_thumbnail,
            sort_order
        )
        VALUES
        (
            ?,?,?,1,1
        )
    ");

    $stmt->execute([

        $product_id,

        $imagePath,

        $name

    ]);

}

/*
|--------------------------------------------------------------------------
| Save Product Features
|--------------------------------------------------------------------------
*/

if (!empty($_POST["features"])) {

    $stmt = $pdo->prepare("
        INSERT INTO product_features
        (
            product_id,
            feature
        )
        VALUES
        (
            ?, ?
        )
    ");

    foreach ($_POST["features"] as $feature) {

        $feature = trim($feature);

        if ($feature == "") {
            continue;
        }

        $stmt->execute([

            $product_id,

            $feature

        ]);

    }

}

/*
|--------------------------------------------------------------------------
| Save SEO
|--------------------------------------------------------------------------
*/

$metaTitle = trim($_POST["meta_title"] ?? "");
$metaDescription = trim($_POST["meta_description"] ?? "");
$metaKeywords = trim($_POST["meta_keywords"] ?? "");

$stmt = $pdo->prepare("
    INSERT INTO product_seo
    (
        product_id,
        meta_title,
        meta_description,
        meta_keywords
    )
    VALUES
    (
        ?, ?, ?, ?
    )
");

$stmt->execute([

    $product_id,

    $metaTitle,

    $metaDescription,

    $metaKeywords

]);

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

header("Location:index.php?success=1");

exit;