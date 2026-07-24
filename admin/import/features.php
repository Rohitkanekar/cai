<?php

echo "<hr>";
echo "<h2>Importing Product Features...</h2>";

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

    $stmt->execute([
        $product["slug"]
    ]);

    $dbProduct = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$dbProduct) {

        $errors++;
        continue;

    }

    $productId = $dbProduct["id"];

    if (empty($product["features"])) {
        continue;
    }

    foreach ($product["features"] as $feature) {

        // Duplicate Check

        $check = $pdo->prepare("
            SELECT id
            FROM product_features
            WHERE product_id = ?
            AND feature = ?
        ");

        $check->execute([
            $productId,
            $feature
        ]);

        if ($check->fetch()) {

            $skipped++;
            continue;

        }

        $insert = $pdo->prepare("
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

        $insert->execute([
            $productId,
            $feature
        ]);

        echo "✅ "
            . htmlspecialchars($product["name"])
            . " → "
            . htmlspecialchars($feature)
            . "<br>";

        $imported++;

    }

}

echo "<hr>";

echo "<h3>Feature Import Completed</h3>";

echo "Imported : $imported <br>";
echo "Skipped : $skipped <br>";
echo "Errors : $errors <br>";