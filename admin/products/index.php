<?php
require_once "../includes/header.php";
require_once "../includes/sidebar.php";
require_once "../includes/config.php";

/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
*/

// Helper function for Indian Currency Formatting (e.g., 1,23,456)
function formatIndianCurrency($num)
{
    if (!is_numeric($num))
        return $num;
    $num = (string) $num;
    $ex = explode(".", $num);
    $no = $ex[0];
    $fraction = "";
    if (count($ex) > 1) {
        $fraction = "." . $ex[1];
    }
    $len = strlen($no);
    if ($len <= 3) {
        $result = $no;
    } else {
        $lastThree = substr($no, -3);
        $restUnits = substr($no, 0, -3);
        $restUnits = (string) $restUnits;
        $formattedRest = '';
        // Process remaining digits in groups of 2
        for ($i = strlen($restUnits) - 1, $count = 0; $i >= 0; $i--, $count++) {
            if ($count > 0 && $count % 2 == 0) {
                $formattedRest = ',' . $formattedRest;
            }
            $formattedRest = $restUnits[$i] . $formattedRest;
        }
        $result = $formattedRest . "," . $lastThree;
    }
    return $result . $fraction;
}

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
| Pagination
|--------------------------------------------------------------------------
*/

$limit = 10;
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

/*
|--------------------------------------------------------------------------
| Total Records
|--------------------------------------------------------------------------
*/

$totalSql = "
    SELECT COUNT(*)
    FROM products p
    LEFT JOIN categories c
    ON c.id = p.category_id
";
if (!empty($where)) {
    $totalSql .= " WHERE " . implode(" AND ", $where);
}
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute($params);
$totalRecords = (int) $totalStmt->fetchColumn();
$totalPages = max(1, ceil($totalRecords / $limit));
if ($page > $totalPages) {
    $page = $totalPages;
    $offset = ($page - 1) * $limit;
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
    COALESCE(pi.image, p.thumbnail) AS thumbnail
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
$sql .= " ORDER BY p.id DESC LIMIT ? OFFSET ?";
$stmt = $pdo->prepare($sql);
$bindIndex = 1;
foreach ($params as $param) {
    $stmt->bindValue($bindIndex++, $param, PDO::PARAM_STR);
}
$stmt->bindValue($bindIndex++, $limit, PDO::PARAM_INT);
$stmt->bindValue($bindIndex++, $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

$categories = $pdo->query("
    SELECT id, name
    FROM categories
    ORDER BY name ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="main-content">
    <?php if (isset($_GET["deleted"])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Product deleted successfully.
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["success"])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Product added successfully.
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["updated"])): ?>
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
        <div>
            <h2 class="mb-1">Products</h2>
            <small class="text-muted">
                Total Products : <strong><?= $totalRecords ?></strong>
            </small>
        </div>
        <a href="add.php" class="btn btn-warning">
            <i class="fa-solid fa-plus"></i> Add Product
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
                            <option value="">All Categories</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat["id"] ?>" <?= (($_GET["category"] ?? "") == $cat["id"]) ? "selected" : "" ?>>
                                    <?= htmlspecialchars($cat["name"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select name="featured" class="form-select">
                            <option value="">Featured</option>
                            <option value="1" <?= (($_GET["featured"] ?? "") === "1") ? "selected" : "" ?>>Yes</option>
                            <option value="0" <?= (($_GET["featured"] ?? "") === "0") ? "selected" : "" ?>>No</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select name="status" class="form-select">
                            <option value="">Status</option>
                            <option value="1" <?= (($_GET["status"] ?? "") === "1") ? "selected" : "" ?>>Active</option>
                            <option value="0" <?= (($_GET["status"] ?? "") === "0") ? "selected" : "" ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-lg-2 d-grid">
                        <button class="btn btn-warning">
                            <i class="fa-solid fa-magnifying-glass"></i> Search
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
                            <th>Id</th>
                            <th width="80">Image</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>SKU</th>
                            <th>Series</th>
                            <th>Shape</th>
                            <th>Size</th>
                            <th>Dimensions (mm) <br><small class="text-white-50">L × B × H</small></th>
                            <th>Dimensions (inch) <br><small class="text-white-50">L × B × H</small></th>
                            <th>Price</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th width="90">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($products): ?>
                            <?php foreach ($products as $product): ?>
                                <?php
                                $sizeStmt = $pdo->prepare("SELECT * FROM product_sizes WHERE product_id = ?");
                                $sizeStmt->execute([$product['id']]);
                                $productSizes = $sizeStmt->fetchAll(PDO::FETCH_ASSOC);

                                // Strip out prefix numbers (e.g. 1785157914_) from the image filename if present
                                $displayThumbnail = $product["thumbnail"] ?? '';
                                if (!empty($displayThumbnail)) {
                                    $pathInfo = pathinfo($displayThumbnail);
                                    $cleanedFilename = preg_replace('/^\d+_/', '', $pathInfo['filename']);
                                    $displayThumbnail = $pathInfo['dirname'] . '/' . $cleanedFilename . '.' . $pathInfo['extension'];
                                }
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($product["id"] ?: "-") ?></td>
                                    <td>
                                        <?php if (!empty($displayThumbnail)): ?>
                                            <img src="../../<?= htmlspecialchars($displayThumbnail) ?>" class="rounded border"
                                                style="object-fit:cover; max-width: 100%; height: auto;">
                                        <?php else: ?>
                                            <span class="text-muted">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($product["name"] ?: "-") ?></td>
                                    <td>
                                        <?= htmlspecialchars($product["category_name"] ?: "-") ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($product["sku"] ?: "-") ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($product["series"] ?: "-") ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($product["shape"] ?: "-") ?>
                                    </td>

                                    <!-- Size Column -->
                                    <td>
                                        <?php if (!empty($productSizes)): ?>
                                            <?php foreach ($productSizes as $sz): ?>
                                                <div style="white-space: nowrap;">
                                                    <?= htmlspecialchars(!empty($sz['size']) ? $sz['size'] : '-') ?></div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>



                                    <!-- Dimensions (mm) Column -->
                                    <td>
                                        <?php if (!empty($productSizes)): ?>
                                            <?php foreach ($productSizes as $sz): ?>
                                                <div style="white-space: nowrap;">
                                                    <?php if (!empty($sz['length_mm']) || !empty($sz['breadth_mm']) || !empty($sz['height_mm'])): ?>
                                                        <?= htmlspecialchars($sz['length_mm'] ?? 0) ?> ×
                                                        <?= htmlspecialchars($sz['breadth_mm'] ?? 0) ?> ×
                                                        <?= htmlspecialchars($sz['height_mm'] ?? 0) ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <!-- Dimensions (inch) Column -->
                                    <td>
                                        <?php if (!empty($productSizes)): ?>
                                            <?php foreach ($productSizes as $sz): ?>
                                                <div style="white-space: nowrap;">
                                                    <?php if (!empty($sz['length_inch']) || !empty($sz['breadth_inch']) || !empty($sz['height_inch'])): ?>
                                                        <?= htmlspecialchars($sz['length_inch'] ?? 0) ?> ×
                                                        <?= htmlspecialchars($sz['breadth_inch'] ?? 0) ?> ×
                                                        <?= htmlspecialchars($sz['height_inch'] ?? 0) ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <!-- Price Column -->
                                    <td>
                                        <?php if (!empty($productSizes)): ?>
                                            <?php foreach ($productSizes as $sz): ?>
                                                <div style="white-space: nowrap;">
                                                    <?= !empty($sz['price']) ? "₹ " . formatIndianCurrency($sz['price']) : '-' ?>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if ($product["featured"]): ?>
                                            <span class="badge bg-warning text-dark">Featured</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($product["status"]): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
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
                                <td colspan="14" class="text-center py-5">No Products Found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Products Pagination">
                            <ul class="pagination">
                                <?php
                                $queryParams = $_GET;
                                unset($queryParams['page']);
                                $queryString = http_build_query($queryParams);
                                $queryString = $queryString ? '&' . $queryString : '';
                                ?>
                                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page - 1 ?><?= $queryString ?>">&laquo;</a>
                                </li>
                                <?php
                                $start = max(1, $page - 2);
                                $end = min($totalPages, $page + 2);
                                for ($i = $start; $i <= $end; $i++):
                                    ?>
                                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?><?= $queryString ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                    <a class="page-link" href="?page=<?= $page + 1 ?><?= $queryString ?>">&raquo;</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="deleteProductName"></strong> ?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="#" id="deleteProductBtn" class="btn btn-danger">Delete</a>
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
        document.getElementById("deleteProductBtn").href = "delete.php?id=" + id;
    });

    document.addEventListener("DOMContentLoaded", function () {
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