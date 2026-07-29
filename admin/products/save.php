<?php
require_once "../includes/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // 1. Retrieve basic form fields
    $name = trim($_POST['name'] ?? '');
    $baseSlug = trim($_POST['slug'] ?? '');
    $category_id = intval($_POST['category_id'] ?? 0);
    $sku = trim($_POST['sku'] ?? '');
    $series = trim($_POST['series'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $material = trim($_POST['material'] ?? '');
    $shape = trim($_POST['shape'] ?? '');
    $color = trim($_POST['color'] ?? '');

    if (empty($name) || empty($baseSlug) || empty($category_id)) {
        die("Please fill in all required fields.");
    }

    // 2. Ensure the slug is unique
    $slug = $baseSlug;
    $counter = 1;
    while (true) {
        $stmtCheck = $pdo->prepare("SELECT id FROM products WHERE slug = ?");
        $stmtCheck->execute([$slug]);
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

    // Create a safe folder name from category name or slug (fallback to 'general')
    $catFolderName = !empty($category['slug']) ? $category['slug'] : (!empty($category['name']) ? strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $category['name']))) : 'general');

    // =============================
    // Upload Directory
    // =============================
    $projectRoot = realpath(__DIR__ . "/../../");

    // Upload Directory
    $targetDir = $projectRoot . DIRECTORY_SEPARATOR .
        "images" . DIRECTORY_SEPARATOR .
        "products" . DIRECTORY_SEPARATOR .
        $catFolderName . DIRECTORY_SEPARATOR;

    // Create directory if it doesn't exist
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0755, true)) {
            die(
                "Unable to create upload directory.<br>" .
                "Directory: " . htmlspecialchars($targetDir)
            );
        }
    }

    // Verify folder exists
    if (!is_dir($targetDir)) {
        die("Upload directory does not exist:<br>" . htmlspecialchars($targetDir));
    }

    // Verify writable
    if (!is_writable($targetDir)) {
        die("Upload directory is not writable:<br>" . htmlspecialchars($targetDir));
    }

    $thumbnailPathDb = "";

    // 4. Handle Thumbnail Upload with Detailed Error Reporting
    if (isset($_FILES['thumbnail'])) {
        if ($_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['thumbnail']['tmp_name'];
            $originalName = $_FILES['thumbnail']['name'];

            $safeFileName = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $originalName);
            $destination = $targetDir . $safeFileName;

            $fileCounter = 1;
            $pathInfo = pathinfo($safeFileName);
            while (file_exists($destination)) {
                $safeFileName = $pathInfo['filename'] . '_' . $fileCounter . '.' . ($pathInfo['extension'] ?? '');
                $destination = $targetDir . $safeFileName;
                $fileCounter++;
            }

            echo "<pre>";
            echo "DOCUMENT_ROOT : " . $_SERVER['DOCUMENT_ROOT'] . PHP_EOL;
            echo "SCRIPT DIR    : " . __DIR__ . PHP_EOL;
            echo "PROJECT ROOT  : " . $projectRoot . PHP_EOL;
            echo "TARGET DIR    : " . $targetDir . PHP_EOL;
            echo "DESTINATION   : " . $destination . PHP_EOL;
            echo "TMP FILE      : " . $fileTmpPath . PHP_EOL;
            echo "TMP EXISTS    : " . (file_exists($fileTmpPath) ? "YES" : "NO") . PHP_EOL;
            echo "DIR EXISTS    : " . (is_dir($targetDir) ? "YES" : "NO") . PHP_EOL;
            echo "DIR WRITABLE  : " . (is_writable($targetDir) ? "YES" : "NO") . PHP_EOL;
            echo "</pre>";

            if (!move_uploaded_file($fileTmpPath, $destination)) {

                echo "<pre>";
                echo "Temp Exists     : " . (file_exists($fileTmpPath) ? "YES" : "NO") . PHP_EOL;
                echo "Target Dir      : " . $targetDir . PHP_EOL;
                echo "Dir Exists      : " . (is_dir($targetDir) ? "YES" : "NO") . PHP_EOL;
                echo "Dir Writable    : " . (is_writable($targetDir) ? "YES" : "NO") . PHP_EOL;
                echo "Destination     : " . $destination . PHP_EOL;
                echo "</pre>";

                $result = move_uploaded_file($fileTmpPath, $destination);

                echo "<pre>";
                echo "move_uploaded_file : ";
                var_dump($result);

                echo "Destination Exists : ";
                var_dump(file_exists($destination));

                echo "</pre>";

                if (!$result) {
                    die("UPLOAD FAILED");
                }
            }

            chmod($destination, 0644);

            $thumbnailPathDb = "images/products/" . $catFolderName . "/" . $safeFileName;
        } elseif ($_FILES['thumbnail']['error'] !== UPLOAD_ERR_NO_FILE) {
            // Catch other upload errors (e.g. file size exceeds server limits)
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
            ];
            $errorCode = $_FILES['thumbnail']['error'];
            $errorMsg = $uploadErrors[$errorCode] ?? 'Unknown upload error code: ' . $errorCode;
            die("Upload Error: " . $errorMsg);
        }
    }

    try {
        $pdo->beginTransaction();

        // 5. Insert into products table
        $stmtInsert = $pdo->prepare("
            INSERT INTO products (name, slug, category_id, sku, series, description, material, shape, color, thumbnail, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())
        ");
        $stmtInsert->execute([
            $name,
            $slug,
            $category_id,
            $sku,
            $series,
            $description,
            $material,
            $shape,
            $color,
            $thumbnailPathDb
        ]);

        $productId = $pdo->lastInsertId();

        // 6. Insert into product_images table
        if (!empty($thumbnailPathDb)) {
            $stmtImg = $pdo->prepare("
                INSERT INTO product_images (product_id, image, is_thumbnail)
                VALUES (?, ?, 1)
            ");
            $stmtImg->execute([$productId, $thumbnailPathDb]);
        }

        // 7. Handle Sizes and Pricing (Supports both Single and Planter Multi-Size options)
        $isPlanterCategory = str_contains(strtolower($category['name'] ?? ''), 'planter');

        if ($isPlanterCategory) {
            // Retrieve planter-specific inputs
            $sizes = $_POST['planter_size'] ?? [];
            $prices = $_POST['planter_price'] ?? [];
            $length_mm = $_POST['planter_length_mm'] ?? [];
            $length_inch = $_POST['planter_length_inch'] ?? [];
            $breadth_mm = $_POST['planter_breadth_mm'] ?? [];
            $breadth_inch = $_POST['planter_breadth_inch'] ?? [];
            $height_mm = $_POST['planter_height_mm'] ?? [];
            $height_inch = $_POST['planter_height_inch'] ?? [];

            for ($i = 0; $i < count($sizes); $i++) {
                if (empty($sizes[$i]))
                    continue;

                $stmtSize = $pdo->prepare("
                    INSERT INTO product_sizes (product_id, size, price, length_mm, length_inch, breadth_mm, breadth_inch, height_mm, height_inch)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmtSize->execute([
                    $productId,
                    $sizes[$i],
                    $prices[$i] ?? 0,
                    $length_mm[$i] ?? 0,
                    ($length_inch[$i] !== '' && isset($length_inch[$i])) ? $length_inch[$i] : null,
                    $breadth_mm[$i] ?? 0,
                    ($breadth_inch[$i] !== '' && isset($breadth_inch[$i])) ? $breadth_inch[$i] : null,
                    $height_mm[$i] ?? 0,
                    ($height_inch[$i] !== '' && isset($height_inch[$i])) ? $height_inch[$i] : null,
                ]);
            }
        } else {
            // Single size configuration for normal products
            $sizes = $_POST['size'] ?? [];
            $prices = $_POST['price'] ?? [];

            $singleSize = $sizes[0] ?? 'Standard';
            $singlePrice = $prices[0] ?? 0;

            $stmtSize = $pdo->prepare("
                INSERT INTO product_sizes (product_id, size, price)
                VALUES (?, ?, ?)
            ");
            $stmtSize->execute([$productId, $singleSize, $singlePrice]);
        }

        // 8. Handle Product Features
        $features = $_POST['features'] ?? [];
        if (!empty($features)) {
            $stmtFeature = $pdo->prepare("
                INSERT INTO product_features (product_id, feature)
                VALUES (?, ?)
            ");
            foreach ($features as $featureText) {
                $trimmedFeature = trim($featureText);
                if (!empty($trimmedFeature)) {
                    $stmtFeature->execute([$productId, $trimmedFeature]);
                }
            }
        }

        $pdo->commit();
        header("Location: index.php?success=1");
        exit;

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error saving product: " . $e->getMessage());
    }
}