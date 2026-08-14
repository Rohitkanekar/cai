<?php

/*
|--------------------------------------------------------------------------
| CONCRETE ARTS INDIA
| Dynamic XML Sitemap
|--------------------------------------------------------------------------
*/

require_once __DIR__ . "/admin/includes/config.php";

/*
|--------------------------------------------------------------------------
| XML CONTENT TYPE
|--------------------------------------------------------------------------
*/

header("Content-Type: application/xml; charset=UTF-8");

/*
|--------------------------------------------------------------------------
| WEBSITE URL
|--------------------------------------------------------------------------
*/

$siteUrl = "https://concreteartsindia.in";

/*
|--------------------------------------------------------------------------
| XML HEADER
|--------------------------------------------------------------------------
*/

echo '<?xml version="1.0" encoding="UTF-8"?>';

?>

<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
>

<?php

/*
|--------------------------------------------------------------------------
| STATIC PAGES
|--------------------------------------------------------------------------
|
| These are the main public pages of the website.
|
*/

$staticPages = [

    [
        "url"      => "/",
        "priority" => "1.0"
    ],

    [
        "url"      => "/about.php",
        "priority" => "0.8"
    ],

    [
        "url"      => "/team.php",
        "priority" => "0.8"
    ],

    [
        "url"      => "/products.php",
        "priority" => "0.9"
    ],

    [
        "url"      => "/projects.php",
        "priority" => "0.8"
    ],

    [
        "url"      => "/gallery.php",
        "priority" => "0.8"
    ],

    [
        "url"      => "/contact.php",
        "priority" => "0.7"
    ]

];


/*
|--------------------------------------------------------------------------
| OUTPUT STATIC PAGES
|--------------------------------------------------------------------------
*/

foreach ($staticPages as $page) {

    $url = $siteUrl . $page["url"];

    echo "<url>\n";

    echo "    <loc>"
        . htmlspecialchars(
            $url,
            ENT_XML1,
            "UTF-8"
        )
        . "</loc>\n";

    echo "    <changefreq>weekly</changefreq>\n";

    echo "    <priority>"
        . $page["priority"]
        . "</priority>\n";

    echo "</url>\n";
}


/*
|--------------------------------------------------------------------------
| PRODUCT PAGES
|--------------------------------------------------------------------------
|
| Only active products with a valid slug are included.
|
*/

$stmt = $pdo->prepare("
    SELECT
        slug
    FROM products
    WHERE status = 1
      AND slug IS NOT NULL
      AND TRIM(slug) != ''
    ORDER BY id DESC
");

$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_COLUMN);


/*
|--------------------------------------------------------------------------
| OUTPUT PRODUCT URLs
|--------------------------------------------------------------------------
|
| Current product URL structure:
|
| product-details.php?slug=PRODUCT-SLUG
|
| Only the slug is required.
|
*/

foreach ($products as $slug) {

    $slug = trim($slug);

    if ($slug === "") {
        continue;
    }

    $productUrl =
        $siteUrl .
        "/product/" .
        rawurlencode($slug);

    echo "<url>\n";

    echo "    <loc>"
        . htmlspecialchars(
            $productUrl,
            ENT_XML1,
            "UTF-8"
        )
        . "</loc>\n";

    echo "    <changefreq>weekly</changefreq>\n";

    echo "    <priority>0.9</priority>\n";

    echo "</url>\n";
}

?>

</urlset>