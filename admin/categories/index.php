<?php

require_once "../includes/header.php";
require_once "../includes/sidebar.php";

/*
|--------------------------------------------------------------------------
| Fetch Categories
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM categories
    ORDER BY sort_order ASC, name ASC
");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">
    <?php if (isset($_GET["success"])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Category deleted successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["error"])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            Cannot delete category because products exist in this category.
            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Categories</h2>
        <a href="add.php" class="btn btn-warning">
            <i class="fa-solid fa-plus"></i>
            Add Category
        </a>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th width="90">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td>
                                        <?= $cat["id"] ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($cat["image"])): ?>
                                            <img src="../../uploads/categories/<?= htmlspecialchars($cat["image"]) ?>" width="60"
                                                class="img-thumbnail">
                                        <?php else: ?>
                                            <span class="text-muted">No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($cat["name"] ?: "-") ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($cat["slug"] ?: "-") ?>
                                    </td>
                                    <td>
                                        <?php if ($cat["status"]): ?>
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
                                        <a href="edit.php?id=<?= $cat["id"] ?>" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteCategoryModal" data-id="<?= $cat["id"] ?>"
                                            data-name="<?= htmlspecialchars($cat["name"]) ?>">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    No Categories Found
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Delete Category Modal -->

<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCategoryModalLabel">
                    Delete Category
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fa-solid fa-triangle-exclamation text-danger mb-3" style="font-size:60px;"></i>
                <h5>Are you sure?</h5>
                <p class="mb-1">
                    You are about to delete
                </p>
                <strong id="deleteCategoryName"></strong>
                <p class="text-danger mt-3 mb-0">
                    This action cannot be undone.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <a href="#" id="confirmDeleteCategory" class="btn btn-danger">
                    Delete
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    const deleteCategoryModal = document.getElementById("deleteCategoryModal");
    deleteCategoryModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const categoryId = button.getAttribute("data-id");
        const categoryName = button.getAttribute("data-name");
        document.getElementById("deleteCategoryName").textContent = categoryName;
        document.getElementById("confirmDeleteCategory").href = "delete.php?id=" + categoryId;
    });

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