<?php
require_once "../includes/header.php";
require_once "../includes/sidebar.php";
require_once "../includes/config.php";

$categories = $pdo->query("SELECT id, name FROM categories ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    #size-rows-container {
        margin: 0 8px;
    }
</style>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Product</h2>
        <a href="index.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="save.php" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Product Name</label>
                        <input type="text" name="name" id="product_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Slug</label>
                        <input type="text" name="slug" id="product_slug" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Category</label>
                        <select name="category_id" id="category_id" class="form-select" required
                            onchange="toggleSizeFields()">
                            <option value="">Select Category</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" data-name="<?= strtolower($cat['name']) ?>">
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">SKU</label>
                        <input type="text" name="sku" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Series</label>
                        <input type="text" name="series" class="form-control">
                    </div>

                    <!-- Non-Planter Single Size & Price Fields -->
                    <div class="col-md-6" id="singleSizeField">
                        <label class="form-label fw-bold">Size</label>
                        <input type="text" name="size[]" id="single_size_input" class="form-control"
                            placeholder="e.g. Standard / 12x12 inches" value="Standard">
                    </div>
                    <div class="col-md-6" id="singlePriceField">
                        <label class="form-label fw-bold">Price (₹)</label>
                        <input type="number" step="0.01" name="price[]" id="single_price_input" class="form-control"
                            placeholder="0.00">
                    </div>

                    <!-- Planter Multiple Sizes & Dimensions Section -->
                    <div class="col-12" id="planterSizeSection" style="display: none;">
                        <hr>
                        <h4 class="mb-3">Planter Sizes & Dimensions</h4>
                        <div id="size-rows-container">
                            <div class="row g-3 size-row align-items-end mt-3 border p-3 rounded bg-light">
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Size Label</label>
                                    <select name="size[]" class="form-select size-dropdown"
                                        onchange="updateSizeDropdowns()">
                                        <option value="">Select Size</option>
                                        <option value="Large">Large</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Small">Small</option>
                                        <option value="Extra Small">Extra Small</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Length (mm / inch)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="length_mm[]" class="form-control"
                                            placeholder="mm">
                                        <input type="number" step="0.01" name="length_inch[]" class="form-control"
                                            placeholder="inch">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Breadth (mm / inch)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="breadth_mm[]" class="form-control"
                                            placeholder="mm">
                                        <input type="number" step="0.01" name="breadth_inch[]" class="form-control"
                                            placeholder="inch">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Height (mm / inch)</label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="height_mm[]" class="form-control"
                                            placeholder="mm">
                                        <input type="number" step="0.01" name="height_inch[]" class="form-control"
                                            placeholder="inch">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Price (₹)</label>
                                    <input type="number" step="0.01" name="price[]" class="form-control">
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="button" class="btn btn-success" id="add-size-row"><i
                                            class="fa fa-plus"></i> Add More</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Features Section -->
                    <div class="col-12 mt-4">
                        <label class="form-label fw-bold">Product Features</label>
                        <div id="features-rows-container">
                            <div class="row g-3 feature-row align-items-center mb-3">
                                <div class="col-md-10">
                                    <input type="text" name="features[]" class="form-control"
                                        placeholder="e.g. Weather resistant and durable finish">
                                </div>
                                <div class="col-md-2 d-grid">
                                    <button type="button" class="btn btn-success" id="add-feature-row">
                                        <i class="fa fa-plus"></i> Add Feature
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <label class="form-label fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Material</label>
                        <input type="text" name="material" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Shape</label>
                        <input type="text" name="shape" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Color / Finish</label>
                        <input type="text" name="color" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Thumbnail Image</label>
                        <input type="file" name="thumbnail" id="thumbnailInput" class="form-control" accept="image/*"
                            required>
                        <div class="mt-3">
                            <img id="thumbnailPreview" src="" alt="Image Preview" class="img-thumbnail"
                                style="display: none; max-height: 150px;">
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-warning px-4">Save Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
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
    document.getElementById('thumbnailInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const preview = document.getElementById('thumbnailPreview');
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
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

        const planterSizeSection = document.getElementById('planterSizeSection');
        const planterInputs = planterSizeSection.querySelectorAll('input, select');

        if (categoryName.includes('planter')) {
            singleSizeField.style.display = 'none';
            singlePriceField.style.display = 'none';
            singleSizeInput.removeAttribute('name');
            singlePriceInput.removeAttribute('name');

            planterSizeSection.style.display = 'block';
            planterInputs.forEach(input => {
                if (input.dataset.originalName) {
                    input.setAttribute('name', input.dataset.originalName);
                }
            });
        } else {
            singleSizeField.style.display = 'block';
            singlePriceField.style.display = 'block';
            singleSizeInput.setAttribute('name', 'size[]');
            singlePriceInput.setAttribute('name', 'price[]');

            planterSizeSection.style.display = 'none';
            planterInputs.forEach(input => {
                if (input.getAttribute('name')) {
                    input.dataset.originalName = input.getAttribute('name');
                    input.removeAttribute('name');
                }
            });
        }
    }

    // Prevent duplicate selections of size dropdowns across rows
    function updateSizeDropdowns() {
        const dropdowns = document.querySelectorAll('.size-dropdown');
        let selectedValues = [];

        dropdowns.forEach(dd => {
            if (dd.value) {
                selectedValues.push(dd.value);
            }
        });

        dropdowns.forEach(dd => {
            let currentValue = dd.value;
            Array.from(dd.options).forEach(option => {
                if (option.value === "") return;
                if (selectedValues.includes(option.value) && option.value !== currentValue) {
                    option.style.display = 'none';
                } else {
                    option.style.display = 'block';
                }
            });
        });
    }

    // Auto-calculate mm <-> inch conversions
    document.addEventListener('input', function (e) {
        if (!e.target.matches('.size-row input[type="number"]')) return;

        const input = e.target;
        const row = input.closest('.size-row');
        if (!row) return;

        const mmToInch = (mm) => (mm && !isNaN(mm)) ? (parseFloat(mm) / 25.4).toFixed(2) : '';
        const inchToMm = (inch) => (inch && !isNaN(inch)) ? (parseFloat(inch) * 25.4).toFixed(2) : '';

        // Length
        if (input.name === 'length_mm[]') {
            row.querySelector('input[name="length_inch[]"]').value = mmToInch(input.value);
        } else if (input.name === 'length_inch[]') {
            row.querySelector('input[name="length_mm[]"]').value = inchToMm(input.value);
        }

        // Breadth
        if (input.name === 'breadth_mm[]') {
            row.querySelector('input[name="breadth_inch[]"]').value = mmToInch(input.value);
        } else if (input.name === 'breadth_inch[]') {
            row.querySelector('input[name="breadth_mm[]"]').value = inchToMm(input.value);
        }

        // Height
        if (input.name === 'height_mm[]') {
            row.querySelector('input[name="height_inch[]"]').value = mmToInch(input.value);
        } else if (input.name === 'height_inch[]') {
            row.querySelector('input[name="height_mm[]"]').value = inchToMm(input.value);
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const planterSizeSection = document.getElementById('planterSizeSection');
        planterSizeSection.querySelectorAll('input, select').forEach(input => {
            if (input.getAttribute('name')) {
                input.dataset.originalName = input.getAttribute('name');
            }
        });

        toggleSizeFields();

        // Add dynamic row for planters
        document.getElementById('add-size-row').addEventListener('click', function () {
            const container = document.getElementById('size-rows-container');
            const firstRow = container.querySelector('.size-row');
            const newRow = firstRow.cloneNode(true);

            newRow.querySelector('.size-dropdown').name = 'size[]';

            const numberInputs = newRow.querySelectorAll('input[type="number"]');
            const fieldNames = ['length_mm[]', 'length_inch[]', 'breadth_mm[]', 'breadth_inch[]', 'height_mm[]', 'height_inch[]', 'price[]'];

            numberInputs.forEach((input, index) => {
                input.value = '';
                input.name = fieldNames[index];
            });

            const btnContainer = newRow.querySelector('.col-md-2.d-grid');
            btnContainer.innerHTML = '<button type="button" class="btn btn-danger remove-size-row"><i class="fa fa-trash"></i> Remove</button>';

            container.appendChild(newRow);
            updateSizeDropdowns();
        });

        // Remove dynamic row
        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-size-row')) {
                e.target.closest('.size-row').remove();
                updateSizeDropdowns();
            }
        });

        // Add & Remove Dynamic Feature Rows
        const featureContainer = document.getElementById('features-rows-container');
        const addFeatureBtn = document.getElementById('add-feature-row');
        if (addFeatureBtn) {
            addFeatureBtn.addEventListener('click', function () {
                const firstRow = featureContainer.querySelector('.feature-row');
                const newRow = firstRow.cloneNode(true);

                newRow.querySelector('input').value = '';

                const btnContainer = newRow.querySelector('.col-md-2.d-grid');
                btnContainer.innerHTML = '<button type="button" class="btn btn-danger remove-feature-row"><i class="fa fa-trash"></i> Remove</button>';

                featureContainer.appendChild(newRow);
            });
        }

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-feature-row')) {
                e.target.closest('.feature-row').remove();
            }
        });
    });
</script>

<?php require_once "../includes/footer.php"; ?>