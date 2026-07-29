<?php
require_once "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    
    if ($id <= 0) {
        die("Invalid product ID.");
    }

    // 1. Retrieve basic form fields
    $name         = trim($_POST['name'] ?? '');
    $baseSlug     = trim($_POST['slug'] ?? '');
    $category_id  = intval($_POST['category_id'] ?? 0);
    $sku          = trim($_POST['sku'] ?? '');
    $series       = trim($_POST['series'] ?? '');
    $material     = trim($_POST['material'] ?? '');
    $color        = trim($_POST['color'] ?? '');
    $shape        = trim($_POST['shape'] ?? '');
    $description  = trim($_POST['description'] ?? '');

    if (empty($name) || empty($baseSlug) || empty($category_id)) {
        die("Please fill in all required fields.");
    }

    // 2. Ensure the slug is unique (ignoring current product ID)
    $slug = $baseSlug;
    $counter = 1;
    while (true) {
        $stmtCheck = $pdo->prepare("SELECT id FROM products WHERE slug = ? AND id != ?");
        $stmtCheck->execute([$slug, $id]);
        if ($stmtCheck->fetch()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        } else {
            break;
        }
    }

    // 3. Fetch category slug/name to determine the subfolder
    $stmtCat = $pdo->prepare("SELECT name, slug FROM categories WHERE id = ?");
    $stmtCat->execute([$category_id]);
    $category = $stmtCat->fetch(PDO::FETCH_ASSOC);

    $catFolderName = !empty($category['slug']) ? $category['slug'] : (!empty($category['name']) ? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category['name']))) : 'general');
    
    $projectRoot = rtrim($_SERVER['DOCUMENT_ROOT'], '/');
    $subfolderPath = '/cai'; // Adjust if your subfolder path differs

    $relativeTargetDir = "/images/products/" . $catFolderName . "/";
    $targetDir = $projectRoot . $subfolderPath . $relativeTargetDir;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $thumbnailSql = "";
    $params = [$name, $slug, $category_id, $sku, $series, $material, $color, $shape, $description];

    // Handle Thumbnail Upload if provided
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath   = $_FILES['thumbnail']['tmp_name'];
        $originalName  = $_FILES['thumbnail']['name'];
        
        $safeFileName  = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $originalName);
        $destination   = $targetDir . $safeFileName;
        $fileCounter = 1;
        $pathInfo = pathinfo($safeFileName);
        while (file_exists($destination)) {
            $safeFileName = $pathInfo['filename'] . '_' . $fileCounter . '.' . ($pathInfo['extension'] ?? '');
            $destination = $targetDir . $safeFileName;
            $fileCounter++;
        }

        if (move_uploaded_file($fileTmpPath, $destination)) {
            $thumbnailPathDb = "images/products/" . $catFolderName . "/" . $safeFileName;
            $thumbnailSql = ", thumbnail = ?";
            $params[] = $thumbnailPathDb;

            // Also update product_images table for thumbnail/gallery sync
            $stmtImgCheck = $pdo->prepare("SELECT id FROM product_images WHERE product_id = ? AND is_thumbnail = 1");
            $stmtImgCheck->execute([$id]);
            if ($stmtImgCheck->fetch()) {
                $stmtImgUpdate = $pdo->prepare("UPDATE product_images SET image = ? WHERE product_id = ? AND is_thumbnail = 1");
                $stmtImgUpdate->execute([$thumbnailPathDb, $id]);
            } else {
                $stmtImgInsert = $pdo->prepare("INSERT INTO product_images (product_id, image, is_thumbnail) VALUES (?, ?, 1)");
                $stmtImgInsert->execute([$id, $thumbnailPathDb]);
            }
        }
    }

    $params[] = $id;

    try {
        $pdo->beginTransaction();

        // Update main product table
        $stmt = $pdo->prepare("UPDATE products SET name = ?, slug = ?, category_id = ?, sku = ?, series = ?, material = ?, color = ?, shape = ?, description = ?" . $thumbnailSql . " WHERE id = ?");
        $stmt->execute($params);

        // Clear existing sizes to replace with updated rows
        $delStmt = $pdo->prepare("DELETE FROM product_sizes WHERE product_id = ?");
        $delStmt->execute([$id]);

        $isPlanterCategory = str_contains(strtolower($category['name'] ?? ''), 'planter');

        if ($isPlanterCategory && isset($_POST['planter_size']) && is_array($_POST['planter_size'])) {
            // Multi-size Planter Loop
            $sizes       = $_POST['planter_size'];
            $prices      = $_POST['planter_price'] ?? [];
            $lengthMm    = $_POST['planter_length_mm'] ?? [];
            $lengthInch  = $_POST['planter_length_inch'] ?? [];
            $heightMm    = $_POST['planter_height_mm'] ?? [];
            $heightInch  = $_POST['planter_height_inch'] ?? [];
            $breadthMm   = $_POST['planter_breadth_mm'] ?? [];      
            $breadthInch = $_POST['planter_breadth_inch'] ?? [];   

            $insertStmt = $pdo->prepare("INSERT INTO product_sizes (product_id, size, price, length_mm, length_inch, height_mm, height_inch, breadth_mm, breadth_inch) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            for ($i = 0; $i < count($sizes); $i++) {
                if (!empty(trim($sizes[$i]))) {
                    $insertStmt->execute([
                        $id,
                        $sizes[$i],
                        ($prices[$i] !== '' && isset($prices[$i])) ? $prices[$i] : 0,
                        ($lengthMm[$i] !== '' && isset($lengthMm[$i])) ? $lengthMm[$i] : null,
                        ($lengthInch[$i] !== '' && isset($lengthInch[$i])) ? $lengthInch[$i] : null,
                        ($heightMm[$i] !== '' && isset($heightMm[$i])) ? $heightMm[$i] : null,
                        ($heightInch[$i] !== '' && isset($heightInch[$i])) ? $heightInch[$i] : null,
                        ($breadthMm[$i] !== '' && isset($breadthMm[$i])) ? $breadthMm[$i] : null,       
                        ($breadthInch[$i] !== '' && isset($breadthInch[$i])) ? $breadthInch[$i] : null       
                    ]);
                }
            }
        } else {
            // Single Size fallback for non-planters
            $sizes  = $_POST['size'] ?? [];
            $prices = $_POST['price'] ?? [];

            $insertStmt = $pdo->prepare("INSERT INTO product_sizes (product_id, size, price, length_mm, length_inch, height_mm, height_inch, breadth_mm, breadth_inch) VALUES (?, ?, ?, NULL, NULL, NULL, NULL, NULL, NULL)");
            
            $singleSize  = $sizes[0] ?? 'Standard';
            $singlePrice = $prices[0] ?? 0;

            if (trim($singleSize) !== '' || trim($singlePrice) !== '') {
                $insertStmt->execute([
                    $id,
                    trim($singleSize),
                    trim($singlePrice) !== '' ? $singlePrice : 0
                ]);
            }
        }

        // Handle Product Features configuration
        $delFeaturesStmt = $pdo->prepare("DELETE FROM product_features WHERE product_id = ?");
        $delFeaturesStmt->execute([$id]);

        if (isset($_POST['features']) && is_array($_POST['features'])) {
            $insertFeatureStmt = $pdo->prepare("INSERT INTO product_features (product_id, feature) VALUES (?, ?)");
            foreach ($_POST['features'] as $featureText) {
                $trimmedFeature = trim($featureText);
                if (!empty($trimmedFeature)) {
                    $insertFeatureStmt->execute([$id, $trimmedFeature]);
                }
            }
        }

        $pdo->commit();
        header("Location: edit.php?id=" . $id . "&success=1");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error updating product: " . $e->getMessage());
    }
}