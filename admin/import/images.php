<?php
echo "<hr>";
echo "<h2>Importing Product Images...</h2>";
$imported = 0;
$skipped = 0;
$errors = 0;
foreach ($products as $product) {

    // Find Product ID
    $stmt = $pdo->prepare("
        SELECT id
        FROM products
        WHERE slug = ?
        LIMIT 1
    ");
    $stmt->execute([$product["slug"]]);
    $dbProduct = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$dbProduct) {
        $errors++;
        continue;
    }
    $productId = $dbProduct["id"];
    if (empty($product["thumbnail"])) {
        continue;
    }

    // Duplicate Check
    $check = $pdo->prepare("
        SELECT id
        FROM product_images
        WHERE product_id = ?
        AND image = ?
        LIMIT 1
    ");
    $check->execute([
        $productId,
        $product["thumbnail"]
    ]);
    if ($check->fetch()) {
        $skipped++;
        continue;
    }

    // Insert Thumbnail
    $insert = $pdo->prepare("
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
            ?, ?, ?, ?, ?
        )
    ");
    $insert->execute([
        $productId,
        $product["thumbnail"],
        $product["name"],
        1,
        1
    ]);
    echo "✅ " . htmlspecialchars($product["name"]) . "<br>";
    $imported++;
}
echo "<hr>";
echo "<h3>Images Import Completed</h3>";
echo "Imported : $imported <br>";
echo "Skipped : $skipped <br>";
echo "Errors : $errors <br>";