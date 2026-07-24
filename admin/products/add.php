<?php

require_once "../includes/header.php";
require_once "../includes/sidebar.php";
require_once "../includes/config.php";

$stmt = $pdo->query("
    SELECT id, name
    FROM categories
    WHERE status = 1
    ORDER BY sort_order ASC, name ASC
");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>Add Product</h2>

            <small class="text-muted">

                Create a new product

            </small>

        </div>

        <a href="index.php" class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>

    <form action="save.php" method="POST" enctype="multipart/form-data">

        <?php require_once "includes/form.php"; ?>

    </form>

</div>

<script>

    const productName = document.getElementById("productName");

    const slug = document.getElementById("slug");

    productName.addEventListener("keyup", function () {

        slug.value = this.value

            .toLowerCase()

            .trim()

            .replace(/[^a-z0-9]+/g, "-")

            .replace(/^-+|-+$/g, "");

    });

    const thumbnail = document.getElementById("thumbnail");
    const preview = document.getElementById("previewImage");

    if (thumbnail) {

        thumbnail.addEventListener("change", function () {

            const file = this.files[0];

            if (!file) return;

            const allowed = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            if (!allowed.includes(file.type)) {

                alert("Only JPG, PNG and WEBP images are allowed.");

                this.value = "";

                preview.style.display = "none";

                return;

            }

            if (file.size > 2 * 1024 * 1024) {

                alert("Maximum file size is 2MB.");

                this.value = "";

                preview.style.display = "none";

                return;

            }

            const reader = new FileReader();

            reader.onload = function (e) {

                preview.src = e.target.result;

                preview.style.display = "block";

            };

            reader.readAsDataURL(file);

        });

    }
</script>



<?php require_once "../includes/footer.php"; ?>