<?php

require_once "../includes/header.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Success / Error Messages
|--------------------------------------------------------------------------
*/

if (isset($_GET["success"])) {
    ?>
    <div class="main-content pb-0">
        <div class="alert alert-success alert-dismissible fade show">
            Enquiry deleted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php
}

if (isset($_GET["error"])) {
    ?>
    <div class="main-content pb-0">
        <div class="alert alert-danger alert-dismissible fade show">
            Unable to delete enquiry.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php
}

/*
|--------------------------------------------------------------------------
| Pagination
|--------------------------------------------------------------------------
*/

$limit = 10;
$page = isset($_GET["page"])
    ? (int) $_GET["page"]
    : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

/*
|--------------------------------------------------------------------------
| Total Records
|--------------------------------------------------------------------------
*/

$totalStmt = $pdo->query("
    SELECT COUNT(*)
    FROM enquiries
");

$totalRecords = (int) $totalStmt->fetchColumn();
$totalPages = ceil($totalRecords / $limit);

/*
|--------------------------------------------------------------------------
| Fetch Enquiries
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM enquiries
    ORDER BY created_at DESC
    LIMIT :limit
    OFFSET :offset
");
$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();
$enquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- <style>
    .table {
        white-space: nowrap;
    }
</style> -->

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Enquiries</h2>
        <span class="badge bg-primary fs-6">
            <?= number_format($totalRecords) ?> Total
        </span>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th width="70">ID</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Source</th>
                            <th>Product</th>
                            <th>Product Category</th>
                            <th>Product Material</th>
                            <th width="140">Product Price</th>
                            <th>Product Size</th>
                            <th>Product Finish</th>
                            <th>Product Image</th>
                            <th width="120">Date</th>
                            <th width="90">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($enquiries)): ?>
                            <?php foreach ($enquiries as $row): ?>
                                <tr>
                                    <td><?= $row["id"] ?></td>
                                    <td><?= htmlspecialchars($row["customer_name"] ?: "-") ?></td>
                                    <td><a
                                            href="tel:<?= htmlspecialchars($row["phone"] ?: "-") ?>"><?= htmlspecialchars($row["phone"] ?: "-") ?></a>
                                    </td>
                                    <td><a
                                            href="mailto:<?= htmlspecialchars($row["email"] ?: "-") ?>"><?= htmlspecialchars($row["email"] ?: "-") ?></a>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($row["customer_address"] ?: "-") ?>
                                    </td>
                                    <td><?= htmlspecialchars($row["source"] ?: "-") ?></td>
                                    <td><?= htmlspecialchars($row["product_name"] ?: "-") ?></td>
                                    <td><?= htmlspecialchars($row["product_category"] ?: "-") ?></td>
                                    <td><?= htmlspecialchars($row["product_material"] ?: "-") ?></td>
                                    <td>
                                        <?= !empty($row["product_price"])
                                            ? "₹ " . number_format((float) $row["product_price"], 0, ".", ",")
                                            : "-" ?>
                                    </td>
                                    <td><?= htmlspecialchars($row["product_size"] ?: "-") ?></td>
                                    <td><?= htmlspecialchars($row["product_finish"] ?: "-") ?></td>
                                    <td>
                                        <?php if (!empty($row["product_image"])): ?>
                                            <img src="<?= htmlspecialchars($row["product_image"]) ?>"
                                                alt="<?= htmlspecialchars($row["product_name"] ?? 'Product') ?>" width="80"
                                                style="object-fit: cover; border-radius: 6px;">
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date("d M Y h:i A", strtotime($row["created_at"] ?: "-")) ?></td>
                                    <td>
                                        <a href="view.php?id=<?= $row["id"] ?>" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteEnquiryModal" data-id="<?= $row["id"] ?>"
                                            data-name="<?= htmlspecialchars($row["customer_name"]) ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    No enquiries found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Bootstrap Pagination -->

            <?php if ($totalPages > 1): ?>
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Enquiries Pagination">
                        <ul class="pagination">

                            <!-- Previous -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page - 1 ?>">
                                    &laquo;
                                </a>
                            </li>

                            <?php

                            $start = max(1, $page - 2);
                            $end = min($totalPages, $page + 2);
                            for ($i = $start; $i <= $end; $i++):
                                ?>
                                <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next -->

                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?page=<?= $page + 1 ?>">
                                    &raquo;
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Delete Enquiry Modal -->

<div class="modal fade" id="deleteEnquiryModal" tabindex="-1" aria-labelledby="deleteEnquiryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteEnquiryModalLabel">
                    Delete Enquiry
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa-solid fa-triangle-exclamation text-danger mb-3" style="font-size:60px;"></i>
                <h5>Are you sure?</h5>
                <p class="mb-1">
                    You are about to delete enquiry of
                </p>
                <strong id="enquiryCustomerName"></strong>
                <p class="text-danger mt-3 mb-0">
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <a href="#" id="confirmDeleteEnquiry" class="btn btn-danger">
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    const deleteEnquiryModal = document.getElementById("deleteEnquiryModal");
    if (deleteEnquiryModal) {
        deleteEnquiryModal.addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget;
            const enquiryId = button.getAttribute("data-id");
            const customerName = button.getAttribute("data-name");
            document.getElementById("enquiryCustomerName").textContent = customerName;
            document.getElementById("confirmDeleteEnquiry").href = "delete.php?id=" + enquiryId;
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
    const alerts = document.querySelectorAll(".alert");
    alerts.forEach(function (alert) {
        setTimeout(function () {
            // Using Bootstrap's built-in alert close transition if available
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 3000); // 3000 milliseconds = 3 seconds
    });
});
</script>

<?php require_once "../includes/footer.php"; ?>