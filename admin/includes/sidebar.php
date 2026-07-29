<!-- Sidebar -->

<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$currentDir = basename(dirname($_SERVER['PHP_SELF']));
?>
<style>
    .active {
        background: #b88e2f;
        color: #fff;
    }
</style>
<div class="sidebar">
    <div class="logo">
        <img src="<?= ADMIN_URL ?>assets/images/logo.png" alt="Concrete Arts India">
    </div>
    <ul>
        <li>
            <a href="<?= ADMIN_URL ?>dashboard.php" class="<?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">
                <i class="fa-solid fa-gauge-high"></i>
                Dashboard
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>products/index.php" class="<?= $currentDir == 'products' ? 'active' : '' ?>">
                <i class="fa-solid fa-cube"></i>
                Products
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>categories/index.php" class="<?= $currentDir == 'categories' ? 'active' : '' ?>">
                <i class="fa-solid fa-layer-group"></i>
                Categories
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>enquiries/index.php" class="<?= $currentDir == 'enquiries' ? 'active' : '' ?>">
                <i class="fa-solid fa-envelope"></i>
                Enquiries
            </a>
        </li>
        <li>
            <a href="<?= ADMIN_URL ?>logout.php">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
        </li>
    </ul>
</div>