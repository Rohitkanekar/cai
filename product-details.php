<?php

require_once __DIR__ . "/admin/includes/config.php";

$productSlug = $_GET['slug'] ?? '';

/*
|--------------------------------------------------------------------------
| PRODUCT SEO DATA
|--------------------------------------------------------------------------
*/

$slug = trim($_GET['slug'] ?? '');

if ($slug === '') {
    http_response_code(404);
    require __DIR__ . "/404.php";
    exit;
}


/*
|--------------------------------------------------------------------------
| FETCH PRODUCT
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        p.id,
        p.name,
        p.slug,
        p.sku,
        p.item_code,
        p.catalog,
        p.series,
        p.description,
        p.material,
        p.shape,
        p.finish,
        p.color,
        p.featured,
        p.status,
        p.thumbnail AS main_thumbnail,

        c.id AS category_id,
        c.name AS category_name,
        c.slug AS category_slug

    FROM products p

    LEFT JOIN categories c
        ON c.id = p.category_id

    WHERE p.slug = ?
      AND p.status = 1

    LIMIT 1
");

$stmt->execute([$slug]);

$productSEO = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$productSEO) {
    http_response_code(404);
    require __DIR__ . "/404.php";
    exit;
}


/*
|--------------------------------------------------------------------------
| SEO DATA
|--------------------------------------------------------------------------
*/

$stmtSeo = $pdo->prepare("
    SELECT
        meta_title,
        meta_description,
        meta_keywords
    FROM product_seo
    WHERE product_id = ?
    LIMIT 1
");

$stmtSeo->execute([$productSEO['id']]);

$productSEOData = $stmtSeo->fetch(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| PRODUCT SIZES / PRICES
|--------------------------------------------------------------------------
*/

$stmtSizes = $pdo->prepare("
    SELECT
        size,
        price
    FROM product_sizes
    WHERE product_id = ?
    ORDER BY id ASC
");

$stmtSizes->execute([$productSEO['id']]);

$productSEOSizes = $stmtSizes->fetchAll(PDO::FETCH_ASSOC);


/*
|--------------------------------------------------------------------------
| PRODUCT THUMBNAIL
|--------------------------------------------------------------------------
*/

$stmtThumb = $pdo->prepare("
    SELECT image
    FROM product_images
    WHERE product_id = ?
      AND is_thumbnail = 1
    LIMIT 1
");

$stmtThumb->execute([$productSEO['id']]);

$productSEOImage = $stmtThumb->fetchColumn();


if (empty($productSEOImage)) {

    $stmtAnyImage = $pdo->prepare("
        SELECT image
        FROM product_images
        WHERE product_id = ?
        ORDER BY id ASC
        LIMIT 1
    ");

    $stmtAnyImage->execute([$productSEO['id']]);

    $productSEOImage = $stmtAnyImage->fetchColumn();
}


if (empty($productSEOImage)) {
    $productSEOImage = $productSEO['main_thumbnail'] ?? '';
}


/*
|--------------------------------------------------------------------------
| CLEAN IMAGE FILENAME
|--------------------------------------------------------------------------
*/

if (!empty($productSEOImage)) {

    $pathInfo = pathinfo($productSEOImage);

    $filename = $pathInfo['filename'] ?? '';
    $extension = $pathInfo['extension'] ?? '';

    if (!empty($filename) && !empty($extension)) {

        $cleanedFilename = preg_replace(
            '/^\d+_/',
            '',
            $filename
        );

        $productSEOImage =
            ($pathInfo['dirname'] !== '.'
                ? $pathInfo['dirname'] . '/'
                : ''
            )
            . $cleanedFilename
            . '.'
            . $extension;
    }
}


/*
|--------------------------------------------------------------------------
| HELPER
|--------------------------------------------------------------------------
*/

function seoEscape($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}


/*
|--------------------------------------------------------------------------
| BASE URL
|--------------------------------------------------------------------------
*/

$siteUrl = 'https://concreteartsindia.in';


/*
|--------------------------------------------------------------------------
| PRODUCT URL
|--------------------------------------------------------------------------
*/

$productUrl =
    $siteUrl .
    '/product/' .
    rawurlencode($productSEO['slug']);


/*
|--------------------------------------------------------------------------
| SEO TITLE
|--------------------------------------------------------------------------
*/

$defaultSeoTitle =
    $productSEO['name'] .
    ' | ' .
    ($productSEO['category_name'] ?: 'Products') .
    ' | Concrete Arts India';

$seoTitle =
    !empty($productSEOData['meta_title'])
    ? trim($productSEOData['meta_title'])
    : $defaultSeoTitle;


/*
|--------------------------------------------------------------------------
| SEO DESCRIPTION
|--------------------------------------------------------------------------
*/

$defaultSeoDescription =
    'Explore ' .
    $productSEO['name'] .
    ' by Concrete Arts India. ' .
    ($productSEO['category_name']
        ? $productSEO['category_name'] . ' manufacturer and supplier in India.'
        : 'Premium architectural and landscape products from Concrete Arts India.'
    );

$seoDescription =
    !empty($productSEOData['meta_description'])
    ? trim($productSEOData['meta_description'])
    : $defaultSeoDescription;


/*
|--------------------------------------------------------------------------
| SEO KEYWORDS
|--------------------------------------------------------------------------
*/

$seoKeywords =
    !empty($productSEOData['meta_keywords'])
    ? trim($productSEOData['meta_keywords'])
    : implode(', ', array_filter([
        $productSEO['name'],
        $productSEO['category_name'],
        $productSEO['material'],
        'Concrete Arts India',
        'architectural products India'
    ]));


/*
|--------------------------------------------------------------------------
| SOCIAL IMAGE
|--------------------------------------------------------------------------
*/

if (!empty($productSEOImage)) {

    if (
        stripos($productSEOImage, 'http://') === 0 ||
        stripos($productSEOImage, 'https://') === 0
    ) {

        $socialImage = $productSEOImage;

    } else {

        $socialImage =
            $siteUrl .
            '/' .
            ltrim($productSEOImage, '/');
    }

} else {

    $socialImage =
        $siteUrl .
        '/images/logo.png';
}


/*
|--------------------------------------------------------------------------
| PRODUCT PRICE DATA FOR STRUCTURED DATA
|--------------------------------------------------------------------------
*/

$productPrices = [];

foreach ($productSEOSizes as $sizeRow) {

    $price = (float) ($sizeRow['price'] ?? 0);

    if ($price > 0) {
        $productPrices[] = $price;
    }
}

if (empty($productPrices)) {

    $stmtSinglePrice = $pdo->prepare("
        SELECT price
        FROM product_sizes
        WHERE product_id = ?
        ORDER BY id ASC
        LIMIT 1
    ");

    $stmtSinglePrice->execute([$productSEO['id']]);

    $singlePrice = (float) $stmtSinglePrice->fetchColumn();

    if ($singlePrice > 0) {
        $productPrices[] = $singlePrice;
    }
}


/*
|--------------------------------------------------------------------------
| PRODUCT SCHEMA
|--------------------------------------------------------------------------
*/

$productSchema = [
    '@type' => 'Product',
    '@id' => $productUrl . '#product',
    'name' => $productSEO['name'],
    'url' => $productUrl,
    'description' => $seoDescription,
    'image' => [$socialImage],
    'brand' => [
        '@type' => 'Brand',
        'name' => 'Concrete Arts India'
    ],
    'manufacturer' => [
        '@type' => 'Organization',
        'name' => 'Concrete Arts India',
        'url' => $siteUrl
    ]
];


if (!empty($productSEO['sku'])) {
    $productSchema['sku'] = $productSEO['sku'];
}

if (!empty($productSEO['category_name'])) {
    $productSchema['category'] = $productSEO['category_name'];
}


/*
|--------------------------------------------------------------------------
| PRODUCT OFFERS
|--------------------------------------------------------------------------
*/

if (count($productPrices) === 1) {

    $productSchema['offers'] = [
        '@type' => 'Offer',
        'url' => $productUrl,
        'priceCurrency' => 'INR',
        'price' => number_format(
            $productPrices[0],
            2,
            '.',
            ''
        ),
        'availability' => 'https://schema.org/InStock',
        'itemCondition' => 'https://schema.org/NewCondition'
    ];

} elseif (count($productPrices) > 1) {

    $productSchema['offers'] = [
        '@type' => 'AggregateOffer',
        'url' => $productUrl,
        'priceCurrency' => 'INR',
        'lowPrice' => number_format(
            min($productPrices),
            2,
            '.',
            ''
        ),
        'highPrice' => number_format(
            max($productPrices),
            2,
            '.',
            ''
        ),
        'offerCount' => count($productPrices),
        'availability' => 'https://schema.org/InStock'
    ];
}


/*
|--------------------------------------------------------------------------
| BREADCRUMB SCHEMA
|--------------------------------------------------------------------------
*/

$breadcrumbSchema = [
    '@type' => 'BreadcrumbList',
    '@id' => $productUrl . '#breadcrumb',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => $siteUrl . '/'
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Products',
            'item' => $siteUrl . '/products.php'
        ]
    ]
];


if (!empty($productSEO['category_name'])) {

    $breadcrumbSchema['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => $productSEO['category_name'],
        'item' =>
            $siteUrl .
            '/products.php?category=' .
            rawurlencode($productSEO['category_slug'] ?? '')
    ];

    $breadcrumbSchema['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => 4,
        'name' => $productSEO['name'],
        'item' => $productUrl
    ];

} else {

    $breadcrumbSchema['itemListElement'][] = [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => $productSEO['name'],
        'item' => $productUrl
    ];
}


/*
|--------------------------------------------------------------------------
| FULL STRUCTURED DATA GRAPH
|--------------------------------------------------------------------------
*/

$structuredData = [
    '@context' => 'https://schema.org',
    '@graph' => [

        [
            '@type' => 'Organization',
            '@id' => $siteUrl . '/#organization',
            'name' => 'Concrete Arts India',
            'url' => $siteUrl . '/',
            'logo' => $siteUrl . '/images/logo.png'
        ],

        $productSchema,

        $breadcrumbSchema

    ]
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="/">


    <!-- =====================================================
         PRIMARY SEO
    ====================================================== -->

    <title>
        <?= seoEscape($seoTitle) ?>
    </title>

    <meta name="description" content="<?= seoEscape($seoDescription) ?>">

    <meta name="keywords" content="<?= seoEscape($seoKeywords) ?>">

    <meta name="author" content="Concrete Arts India">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="googlebot" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="language" content="English">

    <meta name="theme-color" content="#b8864a">


    <!-- =====================================================
         CANONICAL
    ====================================================== -->

    <link rel="canonical" href="<?= seoEscape($productUrl) ?>">


    <!-- =====================================================
         FAVICON
    ====================================================== -->

    <link rel="icon" href="/images/favicon.ico" type="image/x-icon">


    <!-- =====================================================
         OPEN GRAPH
    ====================================================== -->

    <meta property="og:type" content="product">

    <meta property="og:title" content="<?= seoEscape($seoTitle) ?>">

    <meta property="og:description" content="<?= seoEscape($seoDescription) ?>">

    <meta property="og:url" content="<?= seoEscape($productUrl) ?>">

    <meta property="og:site_name" content="Concrete Arts India">

    <meta property="og:image" content="<?= seoEscape($socialImage) ?>">

    <meta property="og:image:alt" content="<?= seoEscape($productSEO['name']) ?>">


    <!-- =====================================================
         TWITTER
    ====================================================== -->

    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="<?= seoEscape($seoTitle) ?>">

    <meta name="twitter:description" content="<?= seoEscape($seoDescription) ?>">

    <meta name="twitter:image" content="<?= seoEscape($socialImage) ?>">

    <meta name="twitter:image:alt" content="<?= seoEscape($productSEO['name']) ?>">


    <!-- =====================================================
         LOCAL SEO
    ====================================================== -->

    <meta name="geo.region" content="IN-MH">

    <meta name="geo.placename" content="Mumbai">

    <meta name="geo.position" content="19.173060;72.964460">

    <meta name="ICBM" content="19.173060,72.964460">


    <!-- =====================================================
         STYLES
    ====================================================== -->

    <link rel="stylesheet" href="/css/style.css?v=<?= filemtime('css/style.css') ?>">

    <link rel="stylesheet" href="/css/product-details.css?v=<?= filemtime('css/product-details.css') ?>">

    <link rel="stylesheet" href="/css/font-awesome.css?v=<?= filemtime('css/font-awesome.css') ?>">


    <!-- =====================================================
         PRODUCT + BREADCRUMB STRUCTURED DATA
    ====================================================== -->

    <script type="application/ld+json">
<?= json_encode(
    $structuredData,
    JSON_PRETTY_PRINT |
    JSON_UNESCAPED_SLASHES |
    JSON_UNESCAPED_UNICODE
) ?>
    </script>

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
                    <a href="mailto:contact.concreteartsindia@gmail.com">
                        <i class="fa-solid fa-envelope"></i>
                        contact.concreteartsindia@gmail.com
                    </a>
                </div>
                <div class="header-right">
                    <a aria-label="Visit our Instagram page" target="_blank" rel="noopener"
                        href="https://www.instagram.com/concreteartsindia.in"><i class="fab fa-instagram"></i></a>
                    <a aria-label="Visit our Facebook page" target="_blank" rel="noopener"
                        href="https://www.facebook.com/concreteartsindia.in"><i class="fab fa-facebook-f"></i></a>
                    <a aria-label="Visit our linkedin page" target="_blank" rel="noopener"
                        href="https://www.linkedin.com/company/concreteartsindia/"><i
                            class="fab fa-linkedin-in"></i></a>
                    <a aria-label="Visit our YouTube Channel" target="_blank" rel="noopener"
                        href="https://www.youtube.com/@ConcreteArtsIndia"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <!-- NAVBAR -->
        <nav class="navbar">
            <div class="container">
                <div class="logo">
                    <a href="/">
                        <img src="/images/logo.png" alt="Concrete Arts India">
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

                    <h1>
                        <?= seoEscape($productSEO['name']) ?>
                    </h1>

                    <p>

                        <a href="index.php">
                            Home
                        </a>

                        <span>/</span>

                        <a href="products.php">
                            Products
                        </a>

                        <span>/</span>

                        <?= seoEscape($productSEO['name']) ?>

                    </p>

                </div>
            </div>
        </section>

        <!-- ==================================== PRODUCTS PAGE ==================================== -->

        <section class="products-page section-padding">
            <div class="container">
                <div id="productDetails"></div>
            </div>
        </section>

        <!-- ==================================== EXPLORE MORE PRODUCTS ==================================== -->

        <section class="products-more section-padding">

            <div class="container">

                <div class="section-heading">
                    <span>RELATED PRODUCTS</span>
                    <h2>You May Also Like</h2>
                </div>

                <div class="product-carousel">

                    <button class="carousel-btn prev">
                        <i class="fa fa-chevron-left"></i>
                    </button>

                    <div class="carousel-wrapper">

                        <div class="carousel-track" id="relatedProducts">

                            <!-- Products Here -->

                        </div>

                    </div>

                    <button class="carousel-btn next">
                        <i class="fa fa-chevron-right"></i>
                    </button>

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
                            href="https://www.instagram.com/concreteartsindia.in"><i class="fab fa-instagram"></i></a>
                        <a aria-label="Visit our Facebook page" target="_blank" rel="noopener"
                            href="https://www.facebook.com/concreteartsindia.in"><i class="fab fa-facebook-f"></i></a>
                        <a aria-label="Visit our linkedin page" target="_blank" rel="noopener"
                            href="https://www.linkedin.com/company/concreteartsindia/"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a aria-label="Visit our YouTube Channel" target="_blank" rel="noopener"
                            href="https://www.youtube.com/@ConcreteArtsIndia"><i class="fa-brands fa-youtube"></i></a>
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
                            <a href="mailto:contact.concreteartsindia@gmail.com">
                                contact.concreteartsindia@gmail.com
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

    <script src="js/script.js?v=<?= filemtime('js/script.js') ?>"></script>
    <script src="/js/product-details.js?v=<?= filemtime('js/product-details.js') ?>"></script>
</body>

</html>