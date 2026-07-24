<?php

header("Content-Type: application/json");

require_once __DIR__ . "/../admin/includes/config.php";

/*
|--------------------------------------------------------------------------
| Products
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
SELECT
    p.id,
    p.name,
    p.slug,
    p.sku,
    p.item_code,
    p.catalog,
    p.series,
    p.description,
    p.material,
    p.shape,
    p.finish,
    p.color,
    p.featured,
    p.status,

    c.id   AS category_id,
    c.name AS category_name,
    c.slug AS category_slug

FROM products p

LEFT JOIN categories c
ON c.id = p.category_id

WHERE p.status = 1

ORDER BY p.id DESC
");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$result = [];

foreach ($products as $product) {

    /*
    |--------------------------------------------------------------------------
    | All Sizes
    |--------------------------------------------------------------------------
    */

    $stmtSize = $pdo->prepare("
        SELECT *
        FROM product_sizes
        WHERE product_id=?
        ORDER BY id ASC
    ");

    $stmtSize->execute([$product["id"]]);

    $sizesData = $stmtSize->fetchAll(PDO::FETCH_ASSOC);

    $sizes = [];

    foreach ($sizesData as $row) {

        $sizes[] = [

            "size" => $row["size"],

            "price" => (float) $row["price"],

            "dimensions" => [

                "length" => [
                    "mm" => (int) $row["length_mm"],
                    "inch" => $row["length_inch"] != "" ? (float) $row["length_inch"] : null
                ],

                "height" => [
                    "mm" => (int) $row["height_mm"],
                    "inch" => $row["height_inch"] != "" ? (float) $row["height_inch"] : null
                ],

                "breadth" => [
                    "mm" => (int) $row["breadth_mm"],
                    "inch" => $row["breadth_inch"] != "" ? (float) $row["breadth_inch"] : null
                ]

            ]

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
    */

    $stmtThumb = $pdo->prepare("
        SELECT image
        FROM product_images
        WHERE product_id=?
        AND is_thumbnail=1
        LIMIT 1
    ");

    $stmtThumb->execute([$product["id"]]);

    $thumbnail = $stmtThumb->fetchColumn();

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    */

    $stmtFeature = $pdo->prepare("
        SELECT feature
        FROM product_features
        WHERE product_id=?
        ORDER BY id ASC
    ");

    $stmtFeature->execute([$product["id"]]);

    $features = $stmtFeature->fetchAll(PDO::FETCH_COLUMN);

    /*
    |--------------------------------------------------------------------------
    | SEO
    |--------------------------------------------------------------------------
    */

    $stmtSeo = $pdo->prepare("
        SELECT *
        FROM product_seo
        WHERE product_id=?
        LIMIT 1
    ");

    $stmtSeo->execute([$product["id"]]);

    $seo = $stmtSeo->fetch(PDO::FETCH_ASSOC);

    /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

    $item = [
        "category" => [
            "id" => $product["category_id"],
            "name" => $product["category_name"],
            "slug" => $product["category_slug"]
        ],
        "id" => (int) $product["id"],
        "name" => $product["name"],
        "slug" => $product["slug"],
        "sku" => $product["sku"],
        "itemCode" => $product["item_code"],
        "catalog" => $product["catalog"],
        "series" => $product["series"],
        "description" => $product["description"],
        "material" => $product["material"],
        "shape" => $product["shape"],
        "finish" => $product["finish"],
        "color" => $product["color"],
        "featured" => (bool) $product["featured"],
        "status" => (bool) $product["status"],
        "thumbnail" => $thumbnail,
        "features" => $features,
        "seo" => [
            "title" => $seo["meta_title"] ?? "",
            "description" => $seo["meta_description"] ?? "",
            "keywords" => $seo["meta_keywords"] ?? ""
        ]
    ];

    /*
    |--------------------------------------------------------------------------
    | Planters = sizes[]
    |--------------------------------------------------------------------------
    */

    if (count($sizes) > 1) {

        $item["sizes"] = $sizes;

    }

    /*
    |--------------------------------------------------------------------------
    | Other Products = price + size
    |--------------------------------------------------------------------------
    */ else {

        if (!empty($sizes)) {

            $first = $sizes[0];

            $item["price"] = $first["price"];

            $item["size"] = $first["size"];

            $item["dimensions"] = $first["dimensions"];

        } else {

            $item["price"] = 0;

            $item["size"] = null;

            $item["dimensions"] = null;

        }

    }

    $result[] = $item;

}

echo json_encode([
    "success" => true,
    "products" => $result
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);