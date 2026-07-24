<?php

echo "<hr>";
echo "<h2>Importing Product SEO...</h2>";

$imported = 0;
$skipped = 0;
$errors = 0;

foreach ($products as $product) {

    if (empty($product["seo"])) {
        continue;
    }

    // Find Product

    $stmt = $pdo->prepare("
        SELECT id
        FROM products
        WHERE slug = ?
        LIMIT 1
    ");

    $stmt->execute([
        $product["slug"]
    ]);

    $dbProduct = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dbProduct) {

        $errors++;
        continue;

    }

    $productId = $dbProduct["id"];

    // Duplicate Check

    $check = $pdo->prepare("
        SELECT id
        FROM product_seo
        WHERE product_id = ?
        LIMIT 1
    ");

    $check->execute([$productId]);

    if ($check->fetch()) {

        $skipped++;
        continue;

    }

    // Convert keywords array to string

    $keywords = "";

    if (!empty($product["seo"]["keywords"])) {

        $keywords = implode(", ", $product["seo"]["keywords"]);

    }

    $insert = $pdo->prepare("
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

    $insert->execute([

        $productId,

        $product["seo"]["title"] ?? "",

        $product["seo"]["description"] ?? "",

        $keywords

    ]);

    echo "✅ "
        . htmlspecialchars($product["name"])
        . "<br>";

    $imported++;

}

echo "<hr>";

echo "<h3>SEO Import Completed</h3>";

echo "Imported : $imported <br>";
echo "Skipped : $skipped <br>";
echo "Errors : $errors <br>";