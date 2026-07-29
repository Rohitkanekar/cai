<?php
// Include your database configuration file
require_once "../../includes/config.php";

echo "<h2>Importing Products...</h2>";
$imported = 0;
$skipped = 0;
$errors = 0;
$pdo->beginTransaction();

try {
    foreach ($products as $product) {

        // Find Category
        $categorySlug = strtolower(trim($product['category'] ?? ''));
        $stmt = $pdo->prepare("
            SELECT id, name
            FROM categories
            WHERE slug = ?
            LIMIT 1
        ");
        $stmt->execute([$categorySlug]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$category) {
            echo "<span style='color:red'>Category not found : {$categorySlug}</span><br>";
            $errors++;
            continue;
        }
        $categoryId = $category["id"];
        $categoryNameLower = strtolower($category['name']);

        // Duplicate Check
        $check = $pdo->prepare("
            SELECT id
            FROM products
            WHERE slug = ?
            LIMIT 1
        ");
        $check->execute([$product["slug"]]);
        if ($check->fetch()) {
            echo "⏩ Skipped : {$product["name"]}<br>";
            $skipped++;
            continue;
        }

        // Insert Product
        $insert = $pdo->prepare("
        INSERT INTO products(
            category_id, name, slug, sku, item_code, catalog, 
            series, description, material, shape, color, finish, 
            thumbnail, featured, status
        )
        VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

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
        
        $productId = $pdo->lastInsertId();

        // Insert Sizes & Pricing based on Product/Category Type
        if (strpos($categoryNameLower, 'planter') === false) {
            // Non-Planters (Statues, Benches, etc.): Use single size/price properties
            $sizeVal = trim($product['single_size'] ?? $product['size'] ?? 'Standard');
            $priceVal = $product['single_price'] ?? $product['price'] ?? 0;

            $sizeInsert = $pdo->prepare("
                INSERT INTO product_sizes (product_id, size, price)
                VALUES (?, ?, ?)
            ");
            $sizeInsert->execute([$productId, $sizeVal, $priceVal]);
        } else {
            // Planters: Use multi-size array structure if available
            if (!empty($product['sizes']) && is_array($product['sizes'])) {
                foreach ($product['sizes'] as $sz) {
                    $sizeInsert = $pdo->prepare("
                        INSERT INTO product_sizes (product_id, size, length_mm, length_inch, height_mm, height_inch, breadth_mm, breadth_inch, price)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                    ");
                    $sizeInsert->execute([
                        $productId,
                        $sz['size'] ?? 'Standard',
                        $sz['length_mm'] ?? null,
                        $sz['length_inch'] ?? null,
                        $sz['height_mm'] ?? null,
                        $sz['height_inch'] ?? null,
                        $sz['breadth_mm'] ?? null,
                        $sz['breadth_inch'] ?? null,
                        $sz['price'] ?? 0
                    ]);
                }
            } else {
                // Fallback default size record if list omitted
                $sizeInsert = $pdo->prepare("
                    INSERT INTO product_sizes (product_id, size, price)
                    VALUES (?, ?, ?)
                ");
                $sizeInsert->execute([$productId, 'Standard', $product['price'] ?? 0]);
            }
        }

        echo "✅ Imported : {$product["name"]}<br>";
        $imported++;
    }
    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die("Import Error: " . $e->getMessage());
}

echo "<hr>";
echo "<h3>Finished</h3>";
echo "Imported : $imported <br>";
echo "Skipped : $skipped <br>";
echo "Errors : $errors <br>";