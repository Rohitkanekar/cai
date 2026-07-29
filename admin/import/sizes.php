<?php
echo "<hr>";
echo "<h2>Importing Product Sizes...</h2>";
$imported = 0;
$skipped = 0;
$errors = 0;
foreach ($products as $product) {

    // Find Product

    $stmt = $pdo->prepare("
        SELECT id
        FROM products
        WHERE slug=?
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
    if (empty($product["sizes"])) {
        continue;
    }
    $sortOrder = 1;
    foreach ($product["sizes"] as $size) {

        // Duplicate Check

        $check = $pdo->prepare("
            SELECT id
            FROM product_sizes
            WHERE product_id=?
            AND size=?
        ");
        $check->execute([
            $productId,
            $size["size"]
        ]);
        if ($check->fetch()) {
            $skipped++;
            $sortOrder++;
            continue;
        }
        $insert = $pdo->prepare("
            INSERT INTO product_sizes(
                product_id,
                size,
                price,
                length_mm,
                length_inch,
                breadth_mm,
                breadth_inch,
                height_mm,
                height_inch,
                sort_order
            )
            VALUES(
                ?,?,?,?,?,?,?,?,?,?
            )
        ");
        $insert->execute([
            $productId,
            $size["size"],
            $size["price"],
            $size["dimensions"]["length"]["mm"] ?? null,
            $size["dimensions"]["length"]["inch"] ?? null,
            $size["dimensions"]["breadth"]["mm"] ?? null,
            $size["dimensions"]["breadth"]["inch"] ?? null,
            $size["dimensions"]["height"]["mm"] ?? null,
            $size["dimensions"]["height"]["inch"] ?? null,
            $sortOrder
        ]);
        echo "✅ "
            . $product["name"]
            . " → "
            . $size["size"]
            . "<br>";
        $imported++;
        $sortOrder++;
    }
}
echo "<hr>";
echo "<h3>Finished</h3>";
echo "Imported : $imported <br>";
echo "Skipped : $skipped <br>";
echo "Errors : $errors <br>";