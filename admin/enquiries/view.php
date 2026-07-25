<?php

require_once "../includes/header.php";
require_once "../includes/sidebar.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {

    header("Location: index.php");
    exit();

}

$id = (int) $_GET["id"];

$stmt = $pdo->prepare("
    SELECT *
    FROM enquiries
    WHERE id = ?
");

$stmt->execute([$id]);

$enquiry = $stmt->fetch();

if (!$enquiry) {

    header("Location: index.php");
    exit();

}

?>


<div class="main-content">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>View Enquiry</h2>

        <a href="index.php" class="btn btn-secondary">

            <i class="fa-solid fa-arrow-left"></i>

            Back

        </a>

    </div>

    <div class="row">

        <!-- Customer Information -->

        <div class="col-lg-6">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-dark text-white">

                    Customer Information

                </div>

                <div class="card-body">

                    <table class="table table-hover table-striped table-bordered align-middle">

                        <tr>
                            <th>Name</th>
                            <td><?= htmlspecialchars($enquiry["customer_name"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td><a href="tel:<?= htmlspecialchars($enquiry["phone"] ?: "-") ?>"><?= htmlspecialchars($enquiry["phone"] ?: "-") ?></a></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td><a href="mailto:<?= htmlspecialchars($enquiry["email"] ?: "-") ?>"><?= htmlspecialchars($enquiry["email"] ?: "-") ?></a></td>
                        </tr>

                        <tr>
                            <th>Address</th>
                            <td><?= htmlspecialchars($enquiry["customer_address"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Source</th>
                            <td><?= htmlspecialchars($enquiry["source"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Subject</th>
                            <td><?= htmlspecialchars($enquiry["subject"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Message</th>
                            <td><?= nl2br(htmlspecialchars($enquiry["message"]) ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <td><?= date("d M Y h:i A", strtotime($enquiry["created_at"]) ?: "-") ?></td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <!-- Product Information -->

        <div class="col-lg-6">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-warning">

                    Product Information

                </div>

                <div class="card-body">

                    <table class="table table-hover table-striped table-bordered align-middle">

                        <tr>
                            <th>Product</th>
                            <td><?= htmlspecialchars($enquiry["product_name"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Category</th>
                            <td><?= htmlspecialchars($enquiry["product_category"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Material</th>
                            <td><?= htmlspecialchars($enquiry["product_material"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Size</th>
                            <td><?= htmlspecialchars($enquiry["product_size"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Price</th>
                            <td>₹ <?= number_format((float) $enquiry["product_price"]) ?></td>
                        </tr>

                        <tr>
                            <th>Length</th>
                            <td><?= htmlspecialchars($enquiry["product_length"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Breadth</th>
                            <td><?= htmlspecialchars($enquiry["product_breadth"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Height</th>
                            <td><?= htmlspecialchars($enquiry["product_height"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Color</th>
                            <td><?= htmlspecialchars($enquiry["product_color"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Finish</th>
                            <td><?= htmlspecialchars($enquiry["product_finish"] ?: "-") ?></td>
                        </tr>

                        <tr>
                            <th>Image</th>
                            <td>
                                <?php if (!empty($enquiry["product_image"])): ?>
                                    <img src="<?= htmlspecialchars($enquiry["product_image"]) ?>"
                                        alt="<?= htmlspecialchars($enquiry["product_name"] ?? 'Product') ?>" width="80"
                                        style="object-fit: cover; border-radius: 6px;">
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>

                        <?php if (!empty($enquiry["product_url"])): ?>

                            <tr>
                                <th>Product URL</th>
                                <td>

                                    <a href="<?= htmlspecialchars($enquiry["product_url"]) ?>" target="_blank">

                                        View Product

                                    </a>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<?php require_once "../includes/footer.php"; ?>