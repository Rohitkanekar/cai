<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/../admin/includes/config.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) {

    echo json_encode([
        "success" => false,
        "message" => "Slug required"
    ]);

    exit;
}

$slug = trim($_GET['slug']);

/*=====================================================
PRODUCT
=====================================================*/

$stmt = $pdo->prepare("
SELECT
    p.*,

    c.id   category_id,
    c.name category_name,
    c.slug category_slug

FROM products p

LEFT JOIN categories c
ON c.id=p.category_id

WHERE
    p.slug=?
AND p.status=1

LIMIT 1
");

$stmt->execute([$slug]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {

    echo json_encode([
        "success" => false,
        "message" => "Product not found"
    ]);

    exit;
}

$productId = $product['id'];


/*=====================================================
ALL SIZES
=====================================================*/

$stmt = $pdo->prepare("
SELECT *
FROM product_sizes
WHERE product_id=?
ORDER BY id ASC
");

$stmt->execute([$productId]);

$dbSizes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sizes = [];

foreach ($dbSizes as $s) {

    $sizes[] = [

        "size" => $s["size"],

        "price" => (int) $s["price"],

        "dimensions" => [

            "length" => [
                "mm" => (int) $s["length_mm"],
                "inch" => (int) $s["length_inch"]
            ],

            "height" => [
                "mm" => (int) $s["height_mm"],
                "inch" => (int) $s["height_inch"]
            ],

            "breadth" => [
                "mm" => (int) $s["breadth_mm"],
                "inch" => (int) $s["breadth_inch"]
            ]

        ]

    ];

}


/*=====================================================
THUMBNAIL
=====================================================*/

$stmt = $pdo->prepare("
SELECT image
FROM product_images
WHERE
product_id=?
AND is_thumbnail=1
LIMIT 1
");

$stmt->execute([$productId]);

$thumb = $stmt->fetch(PDO::FETCH_ASSOC);


/*=====================================================
FEATURES
=====================================================*/

$stmt = $pdo->prepare("
SELECT feature
FROM product_features
WHERE product_id=?
ORDER BY id
");

$stmt->execute([$productId]);

$features = $stmt->fetchAll(PDO::FETCH_COLUMN);


/*=====================================================
SEO
=====================================================*/

$stmt = $pdo->prepare("
SELECT *
FROM product_seo
WHERE product_id=?
LIMIT 1
");

$stmt->execute([$productId]);

$seo = $stmt->fetch(PDO::FETCH_ASSOC);


/*=====================================================
BASE RESPONSE
=====================================================*/

$response = [
    "category" => [
        "id" => $product["category_id"],
        "name" => $product["category_name"],
        "slug" => $product["category_slug"]
    ],
    "id" => $product["id"],
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
    "thumbnail" => $thumb["image"] ?? "",
    "features" => $features,
    "seo" => [
        "title" => $seo["meta_title"] ?? "",
        "description" => $seo["meta_description"] ?? "",
        "keywords" => $seo["meta_keywords"] ?? ""
    ]
];


/*=====================================================
PLANTERS -> sizes[]
OTHERS -> price + size
=====================================================*/

if (strtolower($product["category_slug"]) == "planters") {

    $response["sizes"] = $sizes;

} else {

    if (count($sizes) > 0) {

        $response["price"] = (int) $sizes[0]["price"];

        $response["size"] = $sizes[0]["size"];

    } else {

        $response["price"] = 0;

        $response["size"] = "";

    }

}


/*=====================================================
OUTPUT
=====================================================*/

echo json_encode([

    "success" => true,

    "product" => $response

], JSON_PRETTY_PRINT);