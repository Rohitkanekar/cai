<?php
header("Content-Type: application/json");
require_once __DIR__ . "/../admin/includes/config.php";

$slug = $_GET['slug'] ?? '';

if (empty($slug)) {
    echo json_encode([
        "success" => false,
        "message" => "Product slug is required."
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| Fetch Single Product by Slug
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
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
    p.thumbnail AS main_thumbnail,
    c.id   AS category_id,
    c.name AS category_name,
    c.slug AS category_slug
FROM products p
LEFT JOIN categories c
ON c.id = p.category_id
WHERE p.slug = ? AND p.status = 1
LIMIT 1
");
$stmt->execute([$slug]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo json_encode([
        "success" => false,
        "message" => "Product not found."
    ]);
    exit;
}

/*
|--------------------------------------------------------------------------
| All Sizes & Dimensions
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
                "mm" => (int) ($row["length_mm"] ?? 0),
                "inch" => ($row["length_inch"] !== "" && $row["length_inch"] !== null) ? (float) $row["length_inch"] : null
            ],
            "height" => [
                "mm" => (int) ($row["height_mm"] ?? 0),
                "inch" => ($row["height_inch"] !== "" && $row["height_inch"] !== null) ? (float) $row["height_inch"] : null
            ],
            "breadth" => [
                "mm" => (int) ($row["breadth_mm"] ?? 0),
                "inch" => ($row["breadth_inch"] !== "" && $row["breadth_inch"] !== null) ? (float) $row["breadth_inch"] : null
            ]
        ]
    ];
}

/*
|--------------------------------------------------------------------------
| Thumbnail (With Timestamp Prefix Cleanup & Fallbacks)
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
$rawThumbnail = $stmtThumb->fetchColumn();

if (empty($rawThumbnail)) {
    // Fallback to any image if no explicit thumbnail flag is set
    $stmtAnyImg = $pdo->prepare("
        SELECT image
        FROM product_images
        WHERE product_id=?
        LIMIT 1
    ");
    $stmtAnyImg->execute([$product["id"]]);
    $rawThumbnail = $stmtAnyImg->fetchColumn();
}

if (empty($rawThumbnail)) {
    // Fallback to main products table thumbnail column
    $rawThumbnail = $product["main_thumbnail"] ?? '';
}

$thumbnail = "";
if (!empty($rawThumbnail)) {
    $pathInfo = pathinfo($rawThumbnail);
    $filename = $pathInfo['filename'] ?? '';
    $extension = $pathInfo['extension'] ?? '';
    
    if (!empty($filename) && !empty($extension)) {
        $cleanedFilename = preg_replace('/^\d+_/', '', $filename);
        $thumbnail = ($pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '') . $cleanedFilename . '.' . $extension;
    } else {
        $thumbnail = $rawThumbnail;
    }
}

/*
|--------------------------------------------------------------------------
| Additional Product Images Gallery
|--------------------------------------------------------------------------
*/

$stmtImages = $pdo->prepare("
    SELECT image
    FROM product_images
    WHERE product_id=?
    ORDER BY id ASC
");
$stmtImages->execute([$product["id"]]);
$imagesData = $stmtImages->fetchAll(PDO::FETCH_COLUMN);
$images = [];

foreach ($imagesData as $img) {
    if (!empty($img)) {
        $pathInfo = pathinfo($img);
        $filename = $pathInfo['filename'] ?? '';
        $extension = $pathInfo['extension'] ?? '';
        
        if (!empty($filename) && !empty($extension)) {
            $cleanedFilename = preg_replace('/^\d+_/', '', $filename);
            $images[] = [
                "image" => ($pathInfo['dirname'] !== '.' ? $pathInfo['dirname'] . '/' : '') . $cleanedFilename . '.' . $extension
            ];
        } else {
            $images[] = ["image" => $img];
        }
    }
}

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
| Response Initialization
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
    "images" => $images,
    "features" => $features,
    "seo" => [
        "title" => $seo["meta_title"] ?? "",
        "description" => $seo["meta_description"] ?? "",
        "keywords" => $seo["meta_keywords"] ?? ""
    ]
];

// Check if category is a Planter or has multiple configuration rows
$isPlanter = stripos($product["category_name"] ?? '', 'planter') !== false;

if ($isPlanter || count($sizes) > 1) {
    $item["sizes"] = $sizes;
    $item["size"] = "";
    $item["price"] = 0;
    $item["dimensions"] = null;
} else {
    if (!empty($sizes)) {
        $first = $sizes[0];
        $item["price"] = $first["price"];
        $item["size"] = $first["size"];
        $item["dimensions"] = $first["dimensions"];
        $item["sizes"] = $sizes;
    } else {
        $item["price"] = 0;
        $item["size"] = "";
        $item["dimensions"] = null;
        $item["sizes"] = [];
    }
}

echo json_encode([
    "success" => true,
    "product" => $item
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);