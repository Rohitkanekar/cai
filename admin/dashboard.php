<?php
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// Total Products

$stmt = $pdo->query("
    SELECT COUNT(*) AS total
    FROM products
");

$totalProducts = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Total Categories

$stmt = $pdo->query("
    SELECT COUNT(*) AS total
    FROM categories
");

$totalCategories = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Total Enquiries

$totalEnquiries = $pdo->query('SELECT COUNT(*) FROM enquiries')->fetchColumn();

$todayEnquiries = $pdo
    ->query("
		SELECT COUNT(*)
		FROM enquiries
		WHERE DATE(created_at) = CURDATE()
	")
    ->fetchColumn();

// Total Recent Enquiries

$recentEnquiries = $pdo->query("
        SELECT
        id,
        customer_name,
        phone,
        email,
        product_name,
        created_at
        FROM enquiries
        ORDER BY created_at DESC
        LIMIT 10
        ")->fetchAll();
?>

<div class="main-content">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fa-solid fa-cube fa-2x text-warning mb-3"></i>
                    <h3><?= $totalProducts ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fa-solid fa-layer-group fa-2x text-primary mb-3"></i>
                    <h3><?= $totalCategories ?></h3>
                    <p>Total Categories</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fa-solid fa-envelope fa-2x text-success mb-3"></i>
                    <h3><?= $totalEnquiries ?></h3>
                    <p>Total Enquiries</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="fa-solid fa-calendar-day fa-2x text-danger mb-3"></i>
                    <h3><?= $todayEnquiries ?></h3>
                    <p>Today's Enquiries</p>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow border-0 mt-5">

                <div class="card-header bg-white">

                    <h4 class="mb-0">

                        Recent Enquiries

                    </h4>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover table-striped table-bordered align-middle">

                            <thead>

                                <tr>

                                    <th>#</th>

                                    <th>Customer</th>

                                    <th>Phone</th>

                                    <th>Product</th>

                                    <th>Date</th>

                                    <th width="100">

                                        Action

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php if (count($recentEnquiries)): ?>

                                    <?php foreach ($recentEnquiries as $row): ?>

                                        <tr>

                                            <td>

                                                <?= $row["id"] ?>

                                            </td>

                                            <td>

                                                <?= htmlspecialchars($row["customer_name"] ?: "-") ?>

                                            </td>

                                            <td>

                                                <?= htmlspecialchars($row["phone"] ?: "-") ?>

                                            </td>

                                            <td>

                                                <?= htmlspecialchars($row["product_name"] ?? "-") ?>

                                            </td>

                                            <td>

                                                <?= date("d M Y", strtotime($row["created_at"])) ?>

                                            </td>

                                            <td>

                                                <a href="enquiries/view.php?id=<?= $row["id"] ?>"
                                                    class="btn btn-sm btn-primary">

                                                    View

                                                </a>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <tr>

                                        <td colspan="6" class="text-center">

                                            No enquiries found.

                                        </td>

                                    </tr>

                                <?php endif; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>