<?php require_once './admin/includes/config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <meta name="title" content="Concrete Arts India | Premium Concrete Planters, GRC & FRP Products">
    <meta name="description"
        content="Browse our complete range of premium concrete planters, GRC jali, FRP products, outdoor benches, garden furniture and architectural landscape products.">
    <meta name="keywords"
        content="Concrete Arts India, Concrete Planters, FRP Products, GRC Jali, Outdoor Benches, Landscape Products, Garden Planters, Cement Planters, Concrete Furniture, Architectural Concrete, Garden Decor India">
    <meta name="author" content="Concrete Arts India">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    <meta name="theme-color" content="#b8864a">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Concrete Arts India | Premium Concrete Planters & Landscape Products">
    <meta property="og:description"
        content="Manufacturer of Concrete Planters, GRC Jali, FRP Products, Outdoor Benches, Garden Furniture & Landscape Products across India.">
    <meta property="og:image" content="https://www.concreteartsindia.com/images/og-image.jpg">
    <meta property="og:url" content="https://www.concreteartsindia.com/">
    <meta property="og:site_name" content="Concrete Arts India">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Concrete Arts India">
    <meta name="twitter:description"
        content="Premium Concrete Planters, GRC Jali, FRP Products and Landscape Solutions.">
    <meta name="twitter:image" content="https://www.concreteartsindia.com/images/og-image.jpg">
    <meta name="geo.region" content="IN-MH">
    <meta name="geo.placename" content="Mumbai">
    <meta name="geo.position" content="19.173060;72.964460">
    <meta name="ICBM" content="19.173060,72.964460">
    <meta name="copyright" content="Concrete Arts India">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <script type="application/ld+json">
        {
        "@context":"https://schema.org",
        "@type":"CollectionPage",
        "name":"Products",
        "url":"https://www.concreteartsindia.com/products.php",
        "description":"Browse premium concrete planters, GRC products, FRP products, benches and landscape furniture."
        }
    </script>

    <title>Concrete Products | Concrete Planters | GRC | FRP | Concrete Arts India</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/font-awesome.css">
</head>

<body>

    <!-- ================= LOADER ================= -->

    <div id="loader" class="loader-overlay">
        <div class="loader-content">
            <div class="spinner"></div>
            <p>Please wait...</p>
        </div>
    </div>

    <!-- ================= HEADER ================= -->

    <header>
        <div class="top-header">
            <div class="container">
                <div class="header-left">
                    <a href="tel:+7506865658">
                        <i class="fa-solid fa-phone"></i>
                        +91 75068 65658
                    </a>
                    <a href="mailto:concreteartsindia@gmail.com">
                        <i class="fa-solid fa-envelope"></i>
                        concreteartsindia@gmail.com
                    </a>
                </div>
                <div class="header-right">
                    <a aria-label="Visit our Instagram page" target="_blank" rel="noopener"
                        href="https://www.facebook.com/sharer.php?u=https://www.concreteartsindia.com/"><i
                            class="fab fa-facebook-f"></i></a>
                    <a aria-label="Visit our linkedin page" target="_blank" rel="noopener"
                        href="https://www.linkedin.com/cws/share/?url=https://www.concreteartsindia.com/"><i
                            class="fab fa-linkedin-in"></i></a>
                    <a aria-label="Visit our twitter page" target="_blank" rel="noopener"
                        href="https://twitter.com/share?url=https://www.concreteartsindia.com/&amp;text=Concrete Arts India"><i
                            class="fa-brands fa-x-twitter"></i></a>
                </div>
            </div>
        </div>

        <!-- NAVBAR -->
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <a href="index.php">
                        <img src="images/logo.png" alt="Concrete Arts">
                    </a>
                </div>
                <ul class="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="team.php">Team</a></li>
                    <li><a href="products.php" class="active">Products</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <div class="nav-btn">
                    <a href="contact.php" class="btn-primary">
                        Get Quote
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <!-- ==================================== PAGE BANNER ==================================== -->

        <section class="page-banner">
            <div class="overlay"></div>
            <div class="container">
                <div class="banner-content">
                    <h1>Our Products</h1>
                    <p>
                        Home
                        <span>/</span>
                        Products
                    </p>
                </div>
            </div>
        </section>

        <!-- ==================================== PRODUCTS PAGE ==================================== -->

        <section class="products-page section-padding">
            <div class="container">
                <div class="products-wrapper">

                    <!-- ============================ SIDEBAR ============================ -->

                    <aside class="product-sidebar">
                        <div class="sidebar-card">
                            <h4>Categories</h4>
                            <ul class="category-list">
                                <li>
                                    <button aria-label="Category" type="button" role="button"
                                        class="category-btn active" data-category="all">
                                        All Products
                                    </button>
                                </li>                                
                                <li>
                                    <button aria-label="Category" type="button" role="button" class="category-btn"
                                        data-category="benches">
                                        Benches
                                    </button>
                                </li>
                                <li>
                                    <button aria-label="Category" type="button" role="button" class="category-btn"
                                        data-category="grc">
                                        GRC Jali
                                    </button>
                                </li>
                                <li>
                                    <button aria-label="Category" type="button" role="button" class="category-btn"
                                        data-category="planters">
                                        Planters
                                    </button>
                                </li>
                                <li>
                                    <button aria-label="Category" type="button" role="button" class="category-btn"
                                        data-category="statues">
                                        Statues
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Download Catalogue -->

                        <div class="catalogue-card">
                            <div class="catalogue-icon">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <h3>E-Catalogue</h3>
                            <p>
                                Download our latest catalogue
                                to explore our premium collection.
                            </p>
                            <a href="Catalog.pdf" class="btn-primary" target="_blank">
                                Download
                            </a>
                        </div>
                    </aside>

                    <!-- ============================ RIGHT CONTENT ============================ -->

                    <div class="products-content">

                        <!-- Toolbar -->

                        <div class="products-toolbar">
                            <div class="results-count">
                                Showing
                                <span id="showingCount">
                                    1–9
                                </span>
                                of
                                <span id="totalCount">
                                    60
                                </span>
                                results
                            </div>

                            <div class="toolbar-right">
                                <div class="products-search">
                                    <input type="text" id="productSearch" placeholder="Search products...">
                                </div>
                                <div class="sort-dropdown">
                                    <button class="sort-btn" id="sortBtn">
                                        <span id="selectedSort">Sort By</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <ul class="sort-menu" id="sortMenu">
                                        <li data-sort="default">Sort By</li>
                                        <li data-sort="low">
                                            Price: Low to High
                                        </li>
                                        <li data-sort="high">
                                            Price: High to Low
                                        </li>
                                        <li data-sort="az">
                                            Name: A to Z
                                        </li>
                                        <li data-sort="za">
                                            Name: Z to A
                                        </li>
                                    </ul>
                                </div>

                                <div class="view-btn-wrapper">
                                    <button class="view-btn active" id="gridView" aria-label="Grid" type="button">
                                        <i class="fa-solid fa-grip"></i>
                                    </button>
                                    <button class="view-btn" id="listView" aria-label="List" type="button">
                                        <i class="fa-solid fa-list"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Products -->

                        <div class="products-grid" id="productsGrid"></div>

                        <!-- No Products -->

                        <div class="no-products" id="noProducts">
                            <i class="fa-solid fa-box-open"></i>
                            <h2>No Products Found</h2>
                            <p>
                                Try another category.
                            </p>
                        </div>

                        <!-- Pagination -->

                        <div class="pagination" id="pagination">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ================= FOOTER ================= -->

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- ================= COMPANY INFO ================= -->

                <div class="footer-column">
                    <a href="index.php" class="footer-logo">
                        <img src="images/logo.png" alt="Concrete Arts India">
                    </a>
                    <p class="footer-desc">
                        GST No. 27AGAPJ9480B1ZI
                    </p>
                    <p class="footer-desc">
                        Concrete Arts India is a leading manufacturer of premium
                        architectural concrete products for residential,
                        commercial and landscape projects across India.
                    </p>
                    <div class="footer-social">
                        <a aria-label="Visit our Instagram page" target="_blank" rel="noopener"
                            href="https://www.facebook.com/sharer.php?u=https://www.concreteartsindia.com/">
                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                        </a>
                        <a aria-label="Visit our linkedin page" target="_blank" rel="noopener"
                            href="https://www.linkedin.com/cws/share/?url=https://www.concreteartsindia.com/"><i
                                class="fab fa-linkedin-in" aria-hidden="true"></i></a>
                        <a aria-label="Visit our twitter page" target="_blank" rel="noopener"
                            href="https://twitter.com/share?url=https://www.concreteartsindia.com/&amp;text=Concrete Arts India"><i
                                class="fa-brands fa-x-twitter" aria-hidden="true"></i></a>
                    </div>
                </div>

                <!-- ================= QUICK LINKS ================= -->

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="team.php">Team</a></li>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="projects.php">Projects</a></li>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>

                <!-- ================= CATEGORIES ================= -->

                <div class="footer-column">
                    <h3>Categories</h3>
                    <ul>
                        <li><a href="products.php">Planters</a></li>
                        <li><a href="products.php">Benches</a></li>
                        <li><a href="products.php">GRC Jali</a></li>
                        <li><a href="products.php">Statues</a></li>
                    </ul>
                </div>

                <!-- ================= CONTACT INFO ================= -->

                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <ul class="contact-info">
                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            <span>
                                Concrete Arts India, <br>
                                Office No. 115, Udyog Kshetra, Next To D'Mart, Above Mahindra Showroom,
                                Mulund Goregaon Link Road, Mulund (W), Mumbai - 400 080, Maharashtra, India
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            <a href="tel:+7506865658">
                                +91 75068 65658
                            </a>
                        </li>
                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            <a href="mailto:concreteartsindia@gmail.com">
                                concreteartsindia@gmail.com
                            </a>
                        </li>
                        <li>
                            <i class="fa-solid fa-clock"></i>
                            <span>
                                Mon - Sat : 9:00 AM - 6:00 PM
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ================= FOOTER BOTTOM ================= -->

        <div class="footer-bottom">
            <div class="container">
                <p>
                    © 2026 Concrete Arts India. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/products.js"></script>
</body>

</html>