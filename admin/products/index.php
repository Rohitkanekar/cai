<?php

require_once "../includes/header.php";
require_once "../includes/sidebar.php";
require_once "../includes/config.php";

/*
|--------------------------------------------------------------------------
| Filters
|--------------------------------------------------------------------------
*/

$where = [];
$params = [];

// Search
if (!empty($_GET['search'])) {

    $where[] = "(p.name LIKE ? OR p.sku LIKE ?)";

    $params[] = "%" . $_GET['search'] . "%";
    $params[] = "%" . $_GET['search'] . "%";
}

// Category
if (!empty($_GET['category'])) {

    $where[] = "p.category_id = ?";

    $params[] = $_GET['category'];
}

// Featured
if (isset($_GET['featured']) && $_GET['featured'] !== '') {

    $where[] = "p.featured = ?";

    $params[] = $_GET['featured'];
}

// Status
if (isset($_GET['status']) && $_GET['status'] !== '') {

    $where[] = "p.status = ?";

    $params[] = $_GET['status'];
}

/*
|--------------------------------------------------------------------------
| Products Query
|--------------------------------------------------------------------------
*/

$sql = "

SELECT

    p.*,

    c.name AS category_name,

    pi.image AS thumbnail

FROM products p

LEFT JOIN categories c
ON c.id = p.category_id

LEFT JOIN product_images pi
ON pi.product_id = p.id
AND pi.is_thumbnail = 1

";

if (!empty($where)) {

    $sql .= " WHERE " . implode(" AND ", $where);

}

$sql .= " ORDER BY p.id ASC";


$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

$categories = $pdo->query("
    SELECT id,name
    FROM categories
    ORDER BY name ASC
")->fetchAll(PDO::FETCH_ASSOC);

?>



<div class="main-content">

    <?php if(isset($_GET["deleted"])): ?>

        <div class="alert alert-success alert-dismissible fade show">

            Product deleted successfully.

            <button
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>

    <?php if (isset($_GET["success"])): ?>

        <div class="alert alert-success alert-dismissible fade show">

            Product added successfully.

        </div>

    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="mb-1">
                Products
            </h2>

            <small class="text-muted">

                Total Products :

                <strong><?= count($products) ?></strong>

            </small>

        </div>

        <a href="add.php" class="btn btn-warning">

            <i class="fa-solid fa-plus"></i>

            Add Product

        </a>

    </div>

    <!-- Filters -->

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-lg-4">

                        <input type="text" name="search" class="form-control" placeholder="Search Product / SKU"
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

                    </div>

                    <div class="col-lg-2">

                        <select name="category" class="form-select">

                            <option value="">
                                All Categories
                            </option>

                            <?php foreach ($categories as $cat): ?>

                                <option value="<?= $cat["id"] ?>" <?= (($_GET["category"] ?? "") == $cat["id"]) ? "selected" : "" ?>>

                                    <?= htmlspecialchars($cat["name"]) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <select name="featured" class="form-select">

                            <option value="">
                                Featured
                            </option>

                            <option value="1" <?= (($_GET["featured"] ?? "") === "1") ? "selected" : "" ?>>

                                Yes

                            </option>

                            <option value="0" <?= (($_GET["featured"] ?? "") === "0") ? "selected" : "" ?>>

                                No

                            </option>

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <select name="status" class="form-select">

                            <option value="">
                                Status
                            </option>

                            <option value="1" <?= (($_GET["status"] ?? "") === "1") ? "selected" : "" ?>>

                                Active

                            </option>

                            <option value="0" <?= (($_GET["status"] ?? "") === "0") ? "selected" : "" ?>>

                                Inactive

                            </option>

                        </select>

                    </div>

                    <div class="col-lg-2 d-grid">

                        <button class="btn btn-warning">

                            <i class="fa-solid fa-magnifying-glass"></i>

                            Search

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Products Table -->

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-striped table-bordered align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>
                                Id
                            </th>

                            <th width="80">
                                Image
                            </th>

                            <th>
                                Product
                            </th>

                            <th>
                                SKU
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Series
                            </th>

                            <th>
                                Featured
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="160">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if ($products): ?>

                            <?php foreach ($products as $product): ?>

                                <tr>

                                    <td>

                                        

                                            <?= htmlspecialchars($product["id"] ?: "-") ?>

                                        

                                    </td>

                                    <td>

                                        <?php if (!empty($product["thumbnail"])): ?>

                                            <img src="../../<?= htmlspecialchars($product["thumbnail"]) ?>" width="60" height="60"
                                                class="rounded border" style="object-fit:cover;">

                                        <?php else: ?>

                                            <span class="text-muted">

                                                No Image

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        

                                            <?= htmlspecialchars($product["name"] ?: "-") ?>

                                        

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($product["sku"] ?: "-") ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($product["category_name"] ?: "-") ?>

                                    </td>

                                    <td>

                                        <?= htmlspecialchars($product["series"] ?: "-") ?>

                                    </td>

                                    <td>

                                        <?php if ($product["featured"]): ?>

                                            <span class="badge bg-warning text-dark">

                                                Featured

                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">

                                                No

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php if ($product["status"]): ?>

                                            <span class="badge bg-success">

                                                Active

                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-danger">

                                                Inactive

                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <a href="edit.php?id=<?= $product["id"] ?>" class="btn btn-primary btn-sm">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="<?= $product['id'] ?>"
                                            data-name="<?= htmlspecialchars($product['name']) ?>">

                                            <i class="fa fa-trash"></i>

                                        </button>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    No Products Found

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- Delete Modal -->

<div class="modal fade" id="deleteModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">

                    Delete Product

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                Are you sure you want to delete

                <strong id="deleteProductName"></strong> ?

            </div>

            <div class="modal-footer">

                <button class="btn btn-secondary" data-bs-dismiss="modal">

                    Cancel

                </button>

                <a href="#" id="deleteProductBtn" class="btn btn-danger">

                    Delete

                </a>

            </div>

        </div>

    </div>

</div>

<script>

    const deleteModal = document.getElementById("deleteModal");

    deleteModal.addEventListener("show.bs.modal", function (event) {

        const button = event.relatedTarget;

        const id = button.getAttribute("data-id");
        const name = button.getAttribute("data-name");

        document.getElementById("deleteProductName").textContent = name;

        document.getElementById("deleteProductBtn").href =
            "delete.php?id=" + id;

    });

</script>

<?php require_once "../includes/footer.php"; ?>