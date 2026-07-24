<?php require_once './admin/includes/config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <meta name="title" content="Concrete Arts India | Premium Concrete Planters, GRC & FRP Products">
    <meta name="description"
        content="View our gallery showcasing premium concrete planters, GRC products, FRP products, outdoor furniture and completed landscaping projects.">
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
        "@type":"ImageGallery",
        "name":"Concrete Arts India Gallery",
        "url":"https://www.concreteartsindia.com/gallery.php",
        "description":"Gallery of completed landscape projects, concrete planters and architectural products."
        }
    </script>

    <title>Concrete Products | Concrete Planters | GRC | FRP | Concrete Arts India</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gallery.css">
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
                    <li><a href="products.php">Products</a></li>
                    <li><a href="projects.php">Projects</a></li>
                    <li><a href="gallery.php" class="active">Gallery</a></li>
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
                    <h1>Gallery</h1>
                    <p>
                        Home
                        <span>/</span>
                        Gallery
                    </p>
                </div>
            </div>
        </section>

        <!-- ==================================== GALLERY ==================================== -->

        <section class="gallery-page section-padding">
            <div class="container">

                <!-- Heading -->
                <div class="section-heading">
                    <span>OUR GALLERY</span>
                    <h2>Explore Our Recent Work</h2>
                    <p>
                        Browse our premium collection of concrete planters,
                        landscape furniture, GRC products, sculptures and
                        completed projects.
                    </p>
                </div>

                <!-- Filter Buttons -->
                <div class="gallery-filter">
                    <a aria-label="Gallery" data-filter="all" class="active">All</a>
                    <a aria-label="Gallery" data-filter="benches">Benches</a>
                    <a aria-label="Gallery" data-filter="grc">GRC</a>
                    <a aria-label="Gallery" data-filter="statues">Statues</a>
                    <a aria-label="Gallery" data-filter="planters">Planters</a>
                </div>

                <!-- Gallery Grid -->
                <div class="gallery-grid" id="galleryGrid"></div>
                <div class="gallery-pagination" id="galleryPagination"></div>
            </div>
        </section>

        <!-- ==================================== LIGHTBOX ==================================== -->

        <div class="lightbox">
            <span class="close-lightbox">
                <i class="fa fa-close"></i>
            </span>
            <button class="lightbox-prev">
                <i class="fa  fa-chevron-left"></i>
            </button>
            <img src="" alt="Gallery Image">
            <button class="lightbox-next">
                <i class="fa  fa-chevron-right"></i>
            </button>
        </div>

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
    <script src="js/gallery.js"></script>

</body>

</html>