<?php

echo "<h2>Importing Products...</h2>";

$imported = 0;
$skipped = 0;
$errors = 0;

$pdo->beginTransaction();

try {

    foreach ($products as $product) {

        // Find Category

        $categorySlug = strtolower(trim($product['category']));

        $stmt = $pdo->prepare("
            SELECT id
            FROM categories
            WHERE slug = ?
            LIMIT 1
        ");

        $stmt->execute([$categorySlug]);

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) {

            echo "<span style='color:red'>
                    Category not found :
                    {$categorySlug}
                  </span><br>";

            $errors++;

            continue;

        }

        $categoryId = $category["id"];

        // Duplicate Check

        $check = $pdo->prepare("
            SELECT id
            FROM products
            WHERE slug=?
            LIMIT 1
        ");

        $check->execute([
            $product["slug"]
        ]);

        if ($check->fetch()) {

            echo "⏩ Skipped : {$product["name"]}<br>";

            $skipped++;

            continue;

        }

        // Insert Product

        $insert = $pdo->prepare("

        INSERT INTO products(

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

            color,

            finish,

            thumbnail,

            featured,

            status

        )

        VALUES(

            ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?

        )

        ");

        $insert->execute([

            $categoryId,

            $product["name"],

            $product["slug"],

            $product["sku"] ?? "",

            $product["itemCode"] ?? "",

            $product["catalog"] ?? "",

            $product["series"] ?? "",

            $product["description"] ?? "",

            $product["material"] ?? "",

            $product["shape"] ?? "",

            $product["color"] ?? "",

            $product["finish"] ?? "",

            $product["thumbnail"] ?? "",

            0,

            1

        ]);

        echo "✅ Imported : {$product["name"]}<br>";

        $imported++;

    }

    $pdo->commit();

} catch (Exception $e) {

    $pdo->rollBack();

    die($e->getMessage());

}

echo "<hr>";

echo "<h3>Finished</h3>";

echo "Imported : $imported <br>";

echo "Skipped : $skipped <br>";

echo "Errors : $errors <br>";