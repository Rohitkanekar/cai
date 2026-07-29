<?php
require_once "../includes/header.php";
require_once "../includes/sidebar.php";
require_once "../includes/config.php";

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: index.php");
    exit;
}

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Determine current category name to accurately set initial visibility and attribute states
$currentCategoryName = '';
foreach ($categories as $cat) {
    if ($product['category_id'] == $cat['id']) {
        $currentCategoryName = strtolower($cat['name']);
        break;
    }
}
$isPlanter = str_contains($currentCategoryName, 'planter');

// Fetch existing size/price configuration safely
$sizeStmt = $pdo->prepare("SELECT * FROM product_sizes WHERE product_id = ?");
$sizeStmt->execute([$id]);
$productSizes = $sizeStmt->fetchAll(PDO::FETCH_ASSOC);

// Fallback if empty to prevent undefined variable/offset errors
if (empty($productSizes)) {
    $productSizes = [
        [
            'size' => '',
            'price' => '',
            'length_mm' => '',
            'length_inch' => '',
            'height_mm' => '',
            'height_inch' => '',
            'breadth_mm' => '',
            'breadth_inch' => ''
        ]
    ];
}
$productSize = $productSizes[0];

// Fetch existing product features safely
$featureStmt = $pdo->prepare("SELECT * FROM product_features WHERE product_id = ?");
$featureStmt->execute([$id]);
$productFeatures = $featureStmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($productFeatures)) {
    $productFeatures = [['feature' => '']];
}
?>

<style>
#sizeRowsWrapper {
    margin: 0 4px;
}
</style>

<div class="main-content">
    <?php if (isset($_GET["deleted"])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Product deleted successfully.
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET["success"]) || isset($_GET["updated"])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Product updated successfully.
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET["error"])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= htmlspecialchars($_GET["error"]) ?>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Product</h2>
        <a href="index.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="update.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Product Name</label>
                        <input type="text" name="name" id="product_name" class="form-control"
                            value="<?= htmlspecialchars($product['name']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Slug</label>
                        <input type="text" name="slug" id="product_slug" class="form-control"
                            value="<?= htmlspecialchars($product['slug']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required
                            onchange="toggleSizeFields()">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" data-name="<?= strtolower($cat['name']) ?>"
                                    <?= ($product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">SKU</label>
                        <input type="text" name="sku" class="form-control"
                            value="<?= htmlspecialchars($product['sku']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Series</label>
                        <input type="text" name="series" class="form-control"
                            value="<?= htmlspecialchars($product['series']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Material</label>
                        <input type="text" name="material" class="form-control"
                            value="<?= htmlspecialchars($product['material']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Color / Finish</label>
                        <input type="text" name="color" class="form-control"
                            value="<?= htmlspecialchars($product['color']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Shape</label>
                        <input type="text" name="shape" class="form-control"
                            value="<?= htmlspecialchars($product['shape']) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Thumbnail Image</label>
                        <input type="file" name="thumbnail" id="thumbnailInput" class="form-control" accept="image/*">
                        <?php if (!empty($product['thumbnail'])): ?>
                            <?php
                            $displayThumbnail = $product['thumbnail'];
                            $pathInfo = pathinfo($displayThumbnail);
                            $cleanedFilename = preg_replace('/^\d+_/', '', $pathInfo['filename']);
                            $displayThumbnail = $pathInfo['dirname'] . '/' . $cleanedFilename . '.' . $pathInfo['extension'];
                            ?>
                            <div class="mt-3">
                                <img id="thumbnailPreview" src="../../<?= htmlspecialchars($displayThumbnail) ?>" class="img-thumbnail border"
                                    style="max-height: 150px;">
                            </div>
                        <?php else: ?>
                            <div class="mt-3">
                                <img id="thumbnailPreview" src="" alt="Image Preview" class="img-thumbnail" style="display: none; max-height: 150px;">
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control"
                            rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
                    </div>

                    <!-- Single Size & Price Fields for Non-Planters -->
                    <div class="col-md-4" id="singleSizeField" style="<?= $isPlanter ? 'display: none;' : 'display: block;' ?>">
                        <label class="form-label fw-bold">Size</label>
                        <input type="text" name="<?= $isPlanter ? '' : 'size[]' ?>" id="single_size_input" class="form-control"
                            value="<?= htmlspecialchars($productSize['size']) ?>">
                    </div>
                    <div class="col-md-4" id="singlePriceField" style="<?= $isPlanter ? 'display: none;' : 'display: block;' ?>">
                        <label class="form-label fw-bold">Price (₹)</label>
                        <input type="number" step="0.01" name="<?= $isPlanter ? '' : 'price[]' ?>" id="single_price_input" class="form-control"
                            value="<?= htmlspecialchars($productSize['price']) ?>">
                    </div>

                    <!-- Planter Multi-Size Configuration Box -->
                    <div class="col-12" id="planterSizeContainer" style="<?= $isPlanter ? 'display: block;' : 'display: none;' ?>">
                        <hr>
                        <h4 class="mb-3">Planter Sizes & Dimensions Configuration</h4>
                        <div id="sizeRowsWrapper">
                            <?php foreach ($productSizes as $index => $ps): ?>
                                <div class="row g-2 border p-3 mb-3 rounded bg-light size-row">
                                    <div class="col-md-2">
                                        <label class="form-label fw-bold">Size Option</label>
                                        <select name="planter_size[]" class="form-select size-dropdown"
                                            onchange="updateSizeDropdowns()">
                                            <option value="">Select Size</option>
                                            <?php foreach (['Large', 'Medium', 'Small', 'Extra Small'] as $opt): ?>
                                                <option value="<?= $opt ?>" <?= (strtolower($ps['size']) == strtolower($opt)) ? 'selected' : '' ?>><?= $opt ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-bold">Price (₹)</label>
                                        <input type="number" step="0.01" name="planter_price[]" class="form-control"
                                            value="<?= htmlspecialchars($ps['price']) ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Length (MM / Inch)</label>
                                        <div class="input-group">
                                            <input type="number" step="any" name="planter_length_mm[]" class="form-control"
                                                placeholder="MM" value="<?= htmlspecialchars($ps['length_mm'] ?? '') ?>">
                                            <input type="number" step="any" name="planter_length_inch[]"
                                                class="form-control" placeholder="Inch"
                                                value="<?= htmlspecialchars($ps['length_inch'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Height (MM / Inch)</label>
                                        <div class="input-group">
                                            <input type="number" step="any" name="planter_height_mm[]" class="form-control"
                                                placeholder="MM" value="<?= htmlspecialchars($ps['height_mm'] ?? '') ?>">
                                            <input type="number" step="any" name="planter_height_inch[]"
                                                class="form-control" placeholder="Inch"
                                                value="<?= htmlspecialchars($ps['height_inch'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-bold">Breadth (MM / Inch)</label>
                                        <div class="input-group">
                                            <input type="number" step="any" name="planter_breadth_mm[]" class="form-control"
                                                placeholder="MM" value="<?= htmlspecialchars($ps['breadth_mm'] ?? '') ?>">
                                            <input type="number" step="any" name="planter_breadth_inch[]"
                                                class="form-control" placeholder="Inch"
                                                value="<?= htmlspecialchars($ps['breadth_inch'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 text-end mt-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-size-row">Remove</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" id="addSizeRowBtn" class="btn btn-secondary btn-sm mt-2">+ Add Another Size</button>
                    </div>

                    <!-- Product Features Section -->
                    <div class="col-12 mt-4">
                        <label class="form-label fw-bold">Product Features</label>
                        <div id="features-rows-container">
                            <?php foreach ($productFeatures as $index => $pf): ?>
                                <div class="row g-3 feature-row align-items-center mb-3">
                                    <div class="col-md-10">
                                        <input type="text" name="features[]" class="form-control" 
                                            placeholder="e.g. Weather resistant and durable finish" 
                                            value="<?= htmlspecialchars($pf['feature'] ?? '') ?>">
                                    </div>
                                    <div class="col-md-2 d-grid">
                                        <?php if ($index === 0): ?>
                                            <button type="button" class="btn btn-success" id="add-feature-row">
                                                <i class="fa fa-plus"></i> Add Feature
                                            </button>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-danger remove-feature-row">
                                                <i class="fa fa-trash"></i> Remove
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-warning px-4">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const availableSizes = ['Large', 'Medium', 'Small', 'Extra Small'];

    // Auto Slug Generation
    document.getElementById('product_name').addEventListener('input', function () {
        let name = this.value;
        let slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        document.getElementById('product_slug').value = slug;
    });

    // Thumbnail Image Preview Script
    document.getElementById('thumbnailInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('thumbnailPreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    function toggleSizeFields() {
        const categorySelect = document.getElementById('category_id');
        const selectedOption = categorySelect.options[categorySelect.selectedIndex];
        const categoryName = selectedOption.getAttribute('data-name') || '';

        const singleSizeField = document.getElementById('singleSizeField');
        const singlePriceField = document.getElementById('singlePriceField');
        const singleSizeInput = document.getElementById('single_size_input');
        const singlePriceInput = document.getElementById('single_price_input');
        const planterSizeContainer = document.getElementById('planterSizeContainer');

        if (categoryName.includes('planter')) {
            singleSizeField.style.display = 'none';
            singlePriceField.style.display = 'none';
            singleSizeInput.removeAttribute('name');
            singlePriceInput.removeAttribute('name');

            planterSizeContainer.style.display = 'block';
            updateSizeDropdowns();
        } else {
            singleSizeField.style.display = 'block';
            singlePriceField.style.display = 'block';
            singleSizeInput.setAttribute('name', 'size[]');
            singlePriceInput.setAttribute('name', 'price[]');

            planterSizeContainer.style.display = 'none';
        }
    }

    // Function to completely remove selected sizes from other dropdown options
    function updateSizeDropdowns() {
        const dropdowns = document.querySelectorAll('.size-dropdown');
        const addBtn = document.getElementById('addSizeRowBtn');

        const selectedValues = Array.from(dropdowns).map(select => select.value).filter(val => val !== "");

        dropdowns.forEach(select => {
            const currentValue = select.value;

            select.innerHTML = '<option value="">Select Size</option>';

            availableSizes.forEach(size => {
                if (size === currentValue || !selectedValues.includes(size)) {
                    const opt = document.createElement('option');
                    opt.value = size;
                    opt.textContent = size;
                    if (size === currentValue) {
                        opt.selected = true;
                    }
                    select.appendChild(opt);
                }
            });
        });

        if (dropdowns.length >= availableSizes.length || selectedValues.length >= availableSizes.length) {
            if (addBtn) {
                addBtn.setAttribute('disabled', 'true');
                addBtn.classList.add('disabled');
            }
        } else {
            if (addBtn) {
                addBtn.removeAttribute('disabled');
                addBtn.classList.remove('disabled');
            }
        }
    }

    document.getElementById('addSizeRowBtn')?.addEventListener('click', function () {
        const wrapper = document.getElementById('sizeRowsWrapper');
        const rows = wrapper.querySelectorAll('.size-row');

        if (rows.length < availableSizes.length) {
            const firstRow = wrapper.querySelector('.size-row');
            const newRow = firstRow.cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelectorAll('select').forEach(select => {
                select.selectedIndex = 0;
            });
            wrapper.appendChild(newRow);
            updateSizeDropdowns();
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-size-row')) {
            const rows = document.querySelectorAll('.size-row');
            if (rows.length > 1) {
                e.target.closest('.size-row').remove();
                updateSizeDropdowns();
            } else {
                alert('At least one size configuration is required.');
            }
        }
    });

    // Add & Remove Dynamic Feature Rows Script
    document.addEventListener('DOMContentLoaded', function () {
        const featureContainer = document.getElementById('features-rows-container');
        
        document.addEventListener('click', function(e) {
            if (e.target && (e.target.id === 'add-feature-row' || e.target.closest('#add-feature-row'))) {
                const firstRow = featureContainer.querySelector('.feature-row');
                const newRow = firstRow.cloneNode(true);

                newRow.querySelector('input').value = '';

                const btnContainer = newRow.querySelector('.col-md-2.d-grid');
                btnContainer.innerHTML = '<button type="button" class="btn btn-danger remove-feature-row"><i class="fa fa-trash"></i> Remove</button>';

                featureContainer.appendChild(newRow);
            }

            if (e.target && e.target.closest('.remove-feature-row')) {
                e.target.closest('.feature-row').remove();
            }
        });

        toggleSizeFields();
        updateSizeDropdowns();

        // 3-second Auto-hide Alerts Script
        const alerts = document.querySelectorAll(".alert");
        alerts.forEach(function (alert) {
            setTimeout(function () {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        });
    });
</script>

<?php require_once "../includes/footer.php"; ?>