<?php

require_once "../includes/header.php";
require_once "../includes/sidebar.php";

function slugify($text)
{
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $slug = slugify($name);
    $baseSlug = $slug;
    $count = 1;
    while (true) {
        $checkSlug = $pdo->prepare("
            SELECT COUNT(*)
            FROM categories
            WHERE slug = ?
        ");
        $checkSlug->execute([$slug]);
        if ($checkSlug->fetchColumn() == 0) {
            break;
        }
        $slug = $baseSlug . "-" . $count;
        $count++;
    }
    $status = isset($_POST["status"]) ? 1 : 0;
    $sortOrder = (int) $_POST["sort_order"];
    $image = "";
    if (!empty($_FILES["image"]["name"])) {
        $extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed = ["jpg", "jpeg", "png", "webp"];
        if (in_array($extension, $allowed)) {
            $image = time() . "_" . uniqid() . "." . $extension;
            move_uploaded_file(
                $_FILES["image"]["tmp_name"],
                "../../uploads/categories/" . $image
            );
        }
    }

    // Check if category already exists

    $check = $pdo->prepare("
        SELECT COUNT(*)
        FROM categories
        WHERE name = ?
    ");
    $check->execute([$name]);
    if ($check->fetchColumn() > 0) {
        header("Location:add.php?error=exists");
        exit();
    }
    $stmt = $pdo->prepare("
        INSERT INTO categories
        (
            name,
            slug,
            image,
            status,
            sort_order
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?
        )
    ");
    $stmt->execute([
        $name,
        $slug,
        $image,
        $status,
        $sortOrder
    ]);
    header("Location:add.php?success=1");
    exit();
}
?>

<div class="main-content">
    <?php if (isset($_GET["success"])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            Category added successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET["error"])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            Category exists already.
            <button type="button" class="btn-close" data-bs-dismiss="alert">
            </button>
        </div>
    <?php endif; ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add Category</h2>
        <a href="index.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>
    </div>
    <div class="card shadow border-0">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">

                    <!-- Category Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Category Name
                        </label>
                        <input type="text" id="categoryName" name="name" class="form-control" required>
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Slug
                        </label>
                        <input type="text" id="slug" class="form-control" readonly>
                    </div>

                    <!-- Sort Order -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Sort Order
                        </label>
                        <input type="number" name="sort_order" value="0" class="form-control">
                    </div>

                    <!-- Category Image -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            Category Image
                        </label>
                        <input type="file" name="image" id="image" class="form-control" accept=".jpg,.jpeg,.png,.webp">
                        <div class="mt-3">
                            <img id="preview" src="https://placehold.co/250x180?text=No+Image" class="img-thumbnail"
                                style="max-width:250px;">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label d-block">
                            Status
                        </label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="status" checked>
                            <label class="form-check-label">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-warning">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Save Category
                    </button>
                </div>
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
        if (!file) {
            return;
        }
        const allowed = [
            "image/jpeg",
            "image/png",
            "image/webp"
        ];
        if (!allowed.includes(file.type)) {
            alert("Only JPG, PNG and WEBP images are allowed.");
            this.value = "";
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert("Maximum image size is 2 MB.");
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