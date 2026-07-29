<?php

require_once "../includes/header.php";
require_once "../includes/sidebar.php";

function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location:index.php");
    exit();
}

$id = (int) $_GET["id"];

// Fetch category

$stmt = $pdo->prepare("
SELECT *
FROM categories
WHERE id=?
");

$stmt->execute([$id]);
$category = $stmt->fetch();
if (!$category) {
    header("Location:index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $slug = slugify($name);
    $status = isset($_POST["status"]) ? 1 : 0;
    $sortOrder = (int) $_POST["sort_order"];
    $image = $category["image"];

    // Check duplicate name

    $check = $pdo->prepare("
        SELECT COUNT(*)
        FROM categories
        WHERE name=? AND id!=?
    ");

    $check->execute([$name, $id]);
    if ($check->fetchColumn() > 0) {
        header("Location:edit.php?id=" . $id . "&error=exists");
        exit();
    }

    // Upload new image

    if (!empty($_FILES["image"]["name"])) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "webp"];
        if (in_array($ext, $allowed)) {
            // Delete old image

            if (
                !empty($image) &&
                file_exists("../../uploads/categories/" . $image)
            ) {
                unlink("../../uploads/categories/" . $image);
            }
            $image = time() . "_" . uniqid() . "." . $ext;
            move_uploaded_file(
                $_FILES["image"]["tmp_name"],
                "../../uploads/categories/" . $image
            );
        }
    }
    $stmt = $pdo->prepare("
        UPDATE categories
        SET
            name=?,
            slug=?,
            image=?,
            status=?,
            sort_order=?
        WHERE id=?
    ");

    $stmt->execute([
        $name,
        $slug,
        $image,
        $status,
        $sortOrder,
        $id
    ]);
    header("Location:edit.php?id=" . $id . "&success=1");
    exit();
}

?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Category</h2>
        <a href="index.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
    </div>
    <?php if (isset($_GET["success"])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check"></i>
            Category updated successfully.
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["error"])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fa-solid fa-circle-xmark"></i>
            Category already exists.
        </div>
    <?php endif; ?>
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">

                    <!-- Category Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Category Name
                        </label>
                        <input type="text" id="categoryName" name="name" class="form-control"
                            value="<?= htmlspecialchars($category["name"]) ?>" required>
                    </div>

                    <!-- Slug -->

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Slug
                        </label>
                        <input type="text" id="slug" class="form-control"
                            value="<?= htmlspecialchars($category["slug"]) ?>" readonly>
                    </div>

                    <!-- Sort Order -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" class="form-control"
                            value="<?= $category["sort_order"] ?>">
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block">
                            Status
                        </label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="status"
                                value="<?= $category["status"] ? "checked" : "" ?>">
                            <label class="form-check-label">
                                Active
                            </label>
                        </div>
                    </div>

                    <!-- Upload Image -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Replace Image
                        </label>
                        <input type="file" id="image" name="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                    </div>

                    <!-- Current Image -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Current Image
                        </label>
                        <br>
                        <?php if (!empty($category["image"])): ?>
                            <img id="preview" src="../../uploads/categories/<?= htmlspecialchars($category["image"]) ?>"
                                class="img-thumbnail" style="max-width:250px;">
                        <?php else: ?>
                            <img id="preview" src="https://placehold.co/250x180?text=No+Image" class="img-thumbnail"
                                style="max-width:250px;">
                        <?php endif; ?>
                    </div>
                </div>
                <button class="btn btn-warning">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Update Category
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    const categoryName = document.getElementById("categoryName");
    const slug = document.getElementById("slug");
    categoryName.addEventListener("keyup", function () {
        slug.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");
    });
    const image = document.getElementById("image");
    const preview = document.getElementById("preview");
    image.addEventListener("change", function () {
        const file = this.files[0];
        if (!file) return;
        if (file.size > 2 * 1024 * 1024) {
            alert("Image should be less than 2 MB");
            this.value = "";
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
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