<?php

require_once "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location:index.php");
    exit;
}

$product_id = (int) $_POST["id"];

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
| Duplicate Slug Check
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT id
    FROM products
    WHERE slug=?
    AND id!=?
");

$stmt->execute([

    $slug,

    $product_id

]);

if ($stmt->fetch()) {

    die("Slug already exists.");

}

try {

    $pdo->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Update Product
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        UPDATE products
        SET
            category_id=?,
            name=?,
            slug=?,
            sku=?,
            item_code=?,
            catalog=?,
            series=?,
            description=?,
            material=?,
            shape=?,
            finish=?,
            color=?,
            featured=?,
            status=?
        WHERE id=?
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
        $status,
        $product_id

    ]);

    /*
    |--------------------------------------------------------------------------
    | Refresh Product Sizes
    |--------------------------------------------------------------------------
    */

    /* Delete existing sizes */

    $stmt = $pdo->prepare("
    DELETE FROM product_sizes
    WHERE product_id=?
");

    $stmt->execute([$product_id]);

    /* Insert all sizes */

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
    | Replace Thumbnail
    |--------------------------------------------------------------------------
    */

    if (
        isset($_FILES["thumbnail"]) &&
        $_FILES["thumbnail"]["error"] == 0
    ) {

        $stmt = $pdo->prepare("
            SELECT *
            FROM product_images
            WHERE product_id=?
            AND is_thumbnail=1
            LIMIT 1
        ");

        $stmt->execute([$product_id]);

        $oldImage = $stmt->fetch(PDO::FETCH_ASSOC);

        $uploadDir = "../../uploads/products/";

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

        if ($oldImage) {

            if (
                !empty($oldImage["image"]) &&
                file_exists("../../" . $oldImage["image"])
            ) {

                unlink("../../" . $oldImage["image"]);

            }

            $stmt = $pdo->prepare("
        UPDATE product_images
        SET
            image=?,
            alt_text=?
        WHERE id=?
    ");

            $stmt->execute([

                $imagePath,
                $name,
                $oldImage["id"]

            ]);

        } else {

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

    }

    /*
    |--------------------------------------------------------------------------
    | Refresh Features
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        DELETE FROM product_features
        WHERE product_id=?
    ");

    $stmt->execute([$product_id]);

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
    SELECT id
    FROM product_seo
    WHERE product_id=?
");

    $stmt->execute([$product_id]);

    if ($stmt->fetch()) {

        $stmt = $pdo->prepare("
        UPDATE product_seo
        SET
            meta_title=?,
            meta_description=?,
            meta_keywords=?
        WHERE product_id=?
    ");

        $stmt->execute([

            $metaTitle,
            $metaDescription,
            $metaKeywords,
            $product_id

        ]);

    } else {

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
            ?,?,?,?
        )
    ");

        $stmt->execute([

            $product_id,
            $metaTitle,
            $metaDescription,
            $metaKeywords

        ]);

    }

    $pdo->commit();

    header("Location:index.php?updated=1");

    exit;

} catch (Exception $e) {

    $pdo->rollBack();

    die($e->getMessage());

}