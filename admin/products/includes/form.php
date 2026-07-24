<?php

$categories = $categories ?? [];
$product = $product ?? [];
$productSize = $productSize ?? [];
$productFeatures = $productFeatures ?? [];
$productSEO = $productSEO ?? [];
$thumbnail = $thumbnail ?? [];

?>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">
            Basic Information
        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <!-- Category -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Category
                </label>

                <select name="category_id" class="form-select" required>

                    <option value="">Select Category</option>

                    <?php foreach ($categories as $cat): ?>

                        <option value="<?= $cat['id']; ?>" <?= (($product['category_id'] ?? 0) == $cat['id']) ? 'selected' : ''; ?>>

                            <?= htmlspecialchars($cat['name']); ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- Product Name -->

            <div class="col-md-6 mb-3">

                <label class="form-label">
                    Product Name
                </label>

                <input type="text" id="productName" name="name" class="form-control"
                    value="<?= htmlspecialchars($product['name'] ?? '') ?>">

            </div>

            <!-- Slug -->

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Slug

                </label>

                <input type="text" id="slug" name="slug" class="form-control"
                    value="<?= htmlspecialchars($product['slug'] ?? '') ?>">

            </div>

            <!-- SKU -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    SKU

                </label>

                <input type="text" name="sku" class="form-control"
                    value="<?= htmlspecialchars($product['sku'] ?? '') ?>">

            </div>

            <!-- Item Code -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Item Code

                </label>

                <input type="text" name="item_code" class="form-control"
                    value="<?= htmlspecialchars($product['item_code'] ?? '') ?>">

            </div>

            <!-- Catalog -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Catalog

                </label>

                <input type="text" name="catalog" class="form-control"
                    value="<?= htmlspecialchars($product['catalog'] ?? '') ?>">

            </div>

            <!-- Series -->

            <div class="col-md-3 mb-3">

                <label class="form-label">

                    Series

                </label>

                <input type="text" name="series" class="form-control"
                    value="<?= htmlspecialchars($product['series'] ?? '') ?>">

            </div>

        </div>

    </div>

</div>

<!-- Description -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">

            Description

        </h5>

    </div>

    <div class="card-body">

        <textarea name="description" class="form-control"
            rows="5"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>

    </div>

</div>

<!-- Product Details -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">

            Product Details

        </h5>

    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-3">

                <label>Material</label>

                <input type="text" name="material" class="form-control"
                    value="<?= htmlspecialchars($product['material'] ?? '') ?>">

            </div>

            <div class="col-md-3 mb-3">

                <label>Shape</label>

                <input type="text" name="shape" class="form-control"
                    value="<?= htmlspecialchars($product['shape'] ?? '') ?>">

            </div>

            <div class="col-md-3 mb-3">

                <label>Finish</label>

                <input type="text" name="finish" class="form-control"
                    value="<?= htmlspecialchars($product['finish'] ?? '') ?>">

            </div>

            <div class="col-md-3 mb-3">

                <label>Color</label>

                <input type="text" name="color" class="form-control"
                    value="<?= htmlspecialchars($product['color'] ?? '') ?>">

            </div>

        </div>

    </div>

</div>

<!-- Status -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">

            Status

        </h5>

    </div>

    <div class="card-body">

        <div class="form-check mb-2">

            <input type="checkbox" name="featured" value="1" <?= !empty($product['featured']) ? 'checked' : '' ?>>

            <label class="form-check-label" for="featured">

                Featured Product

            </label>

        </div>

        <div class="form-check">

            <input type="checkbox" name="status" value="1" <?= !empty($product['status']) ? 'checked' : '' ?>>

            <label class="form-check-label" for="status">

                Active

            </label>

        </div>

    </div>

</div>

<!-- Thumbnail -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">

            Product Thumbnail

        </h5>

    </div>

    <div class="card-body">

        <?php if (!empty($thumbnail["image"])): ?>

            <div class="mb-3">

                <label class="form-label">

                    Current Thumbnail

                </label>

                <br>

                <img src="../../<?= htmlspecialchars($thumbnail["image"]) ?>" id="currentThumbnail" class="img-thumbnail"
                    style="max-width:200px;">

            </div>

        <?php endif; ?>

        <div class="mb-3">

            <label class="form-label">

                <?= !empty($thumbnail["image"]) ? "Replace Thumbnail" : "Upload Thumbnail" ?>

            </label>

            <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept=".jpg,.jpeg,.png,.webp">

        </div>

        <img id="previewImage" src="#" class="img-thumbnail" style="display:none;max-width:200px;">

    </div>

</div>

<!-- Product Sizes -->

<?php

$productSizes = $productSizes ?? [];

if (empty($productSizes)) {
    $productSizes[] = [];
}

?>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            Product Sizes

        </h5>

        <button type="button" class="btn btn-success btn-sm" id="addSize">

            <i class="fa-solid fa-plus"></i>

            Add Size

        </button>

    </div>

    <div class="card-body">

        <div id="sizesWrapper">

            <?php foreach ($productSizes as $index => $size): ?>

                <div class="sizeRow card border p-3 mb-3">

                    <div class="row">

                        <div class="col-md-2 mb-3">

                            <label class="form-label">

                                Size

                            </label>

                            <select name="size[]" class="form-select sizeSelect">

                                <?php

                                $sizes = [
                                    "Large",
                                    "Medium",
                                    "Small",
                                    "Extra Small"
                                ];

                                foreach ($sizes as $option):

                                    ?>

                                    <option value="<?= $option ?>" <?= $size["size"] == $option ? "selected" : "" ?>>

                                        <?= $option ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="col-md-1">

                            <label>Length mm</label>

                            <input type="number" name="length_mm[]" class="form-control" value="<?= $size["length_mm"] ?>">

                        </div>

                        <div class="col-md-1">

                            <label>Length inch</label>

                            <input type="number" step="0.01" name="length_inch[]" class="form-control"
                                value="<?= $size["length_inch"] ?>">

                        </div>

                        <div class="col-md-1">

                            <label>Height mm</label>

                            <input type="number" name="height_mm[]" class="form-control" value="<?= $size["height_mm"] ?>">

                        </div>

                        <div class="col-md-1">

                            <label>Height inch</label>

                            <input type="number" step="0.01" name="height_inch[]" class="form-control"
                                value="<?= $size["height_inch"] ?>">

                        </div>

                        <div class="col-md-1">

                            <label>Breadth mm</label>

                            <input type="number" name="breadth_mm[]" class="form-control"
                                value="<?= $size["breadth_mm"] ?>">

                        </div>

                        <div class="col-md-1">

                            <label>Breadth inch</label>

                            <input type="number" step="0.01" name="breadth_inch[]" class="form-control"
                                value="<?= $size["breadth_inch"] ?>">

                        </div>

                        <div class="col-md-2">

                            <label>Price</label>

                            <input type="number" name="price[]" class="form-control" value="<?= $size["price"] ?>">

                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <button type="button" class="btn btn-danger removeSize w-100">

                                Remove

                            </button>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

<!-- Product Features -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">

            Product Features

        </h5>

        <button type="button" class="btn btn-warning btn-sm" id="addFeature">

            <i class="fa-solid fa-plus"></i>

            Add Feature

        </button>

    </div>

    <div class="card-body">

        <div id="featureContainer">

            <?php if (!empty($productFeatures)): ?>

                <?php foreach ($productFeatures as $feature): ?>

                    <div class="input-group mb-3">

                        <input type="text" name="features[]" class="form-control"
                            value="<?= htmlspecialchars($feature['feature']) ?>">

                        <button type="button" class="btn btn-danger removeFeature">

                            <i class="fa-solid fa-trash"></i>

                        </button>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="input-group mb-3">

                    <input type="text" name="features[]" class="form-control">

                    <button type="button" class="btn btn-danger removeFeature">

                        <i class="fa-solid fa-trash"></i>

                    </button>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<!-- SEO -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-header bg-dark text-white">

        <h5 class="mb-0">

            SEO Information

        </h5>

    </div>

    <div class="card-body">

        <div class="mb-3">

            <label class="form-label">

                Meta Title

            </label>

            <input type="text" name="meta_title" class="form-control"
                value="<?= htmlspecialchars($productSEO['meta_title'] ?? '') ?>">

        </div>

        <div class="mb-3">

            <label class="form-label">
                Meta Description
            </label>

            <textarea name="meta_description" rows="4"
                class="form-control"><?= htmlspecialchars($productSEO['meta_description'] ?? '') ?></textarea>

        </div>


        <div class="mb-3">

            <label class="form-label">
                Meta Keywords
            </label>

            <textarea name="meta_keywords" rows="3" class="form-control"
                placeholder="Keyword1, Keyword2, Keyword3"><?= htmlspecialchars($productSEO['meta_keywords'] ?? '') ?></textarea>

        </div>

    </div>

</div>

<!-- Save -->

<div class="text-end mb-5">

    <button class="btn btn-success btn-lg">

        <i class="fa-solid fa-floppy-disk"></i>

        Save Product

    </button>

</div>

<script>

    document.getElementById("addFeature").addEventListener("click", function () {

        let html = `

        <div class="input-group mb-3">

            <input
                type="text"
                name="features[]"
                class="form-control"
                placeholder="Enter Product Feature">

            <button
                type="button"
                class="btn btn-danger removeFeature">

                <i class="fa-solid fa-trash"></i>

            </button>

        </div>

        `;

        document
            .getElementById("featureContainer")
            .insertAdjacentHTML("beforeend", html);

    });

    document.addEventListener("click", function (e) {

        if (e.target.closest(".removeFeature")) {

            let rows = document.querySelectorAll("#featureContainer .input-group");

            if (rows.length > 1) {

                e.target.closest(".input-group").remove();

            }

        }

    });

</script>

<script>

    const availableSizes = [
        "Large",
        "Medium",
        "Small",
        "Extra Small"
    ];

    document.addEventListener("DOMContentLoaded", function () {

        const wrapper = document.getElementById("sizesWrapper");
        const addBtn = document.getElementById("addSize");

        function updateAddButton() {

            const selected = [];

            wrapper.querySelectorAll(".sizeSelect").forEach(select => {

                if (select.value !== "") {
                    selected.push(select.value);
                }

            });

            if (selected.length >= availableSizes.length) {

                addBtn.disabled = true;
                addBtn.innerHTML = '<i class="fa-solid fa-check"></i> All Sizes Added';

            } else {

                addBtn.disabled = false;
                addBtn.innerHTML = '<i class="fa-solid fa-plus"></i> Add Size';

            }

        }

        addBtn.addEventListener("click", function () {

            const selected = [];

            wrapper.querySelectorAll(".sizeSelect").forEach(select => {

                if (select.value !== "") {
                    selected.push(select.value);
                }

            });

            const nextSize = availableSizes.find(size => !selected.includes(size));

            if (!nextSize) {
                alert("All sizes already added.");
                return;
            }

            const clone = wrapper.querySelector(".sizeRow").cloneNode(true);

            clone.querySelectorAll("input").forEach(input => {
                input.value = "";
            });

            clone.querySelector(".sizeSelect").value = nextSize;

            wrapper.appendChild(clone);

            updateAddButton();

        });

        wrapper.addEventListener("click", function (e) {

            if (!e.target.closest(".removeSize")) return;

            if (wrapper.querySelectorAll(".sizeRow").length === 1) {

                alert("At least one size is required.");
                return;

            }

            e.target.closest(".sizeRow").remove();

            updateAddButton();

        });

        wrapper.addEventListener("change", function (e) {

            if (!e.target.classList.contains("sizeSelect")) return;

            const values = [];
            let duplicate = false;

            wrapper.querySelectorAll(".sizeSelect").forEach(select => {

                if (select.value === "") return;

                if (values.includes(select.value)) {
                    duplicate = true;
                }

                values.push(select.value);

            });

            if (duplicate) {

                alert("This size already exists.");

                e.target.value = "";

            }

            updateAddButton();

        });

        updateAddButton();

    });

</script>