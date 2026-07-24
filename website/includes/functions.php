<?php

require_once "config.php";

/*
|--------------------------------------------------------------------------
| Categories
|--------------------------------------------------------------------------
*/

function getCategories()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT *
        FROM categories
        WHERE status = 1
        ORDER BY sort_order ASC, name ASC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Single Category
|--------------------------------------------------------------------------
*/

function getCategory($id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM categories
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Category By Slug
|--------------------------------------------------------------------------
*/

function getCategoryBySlug($slug)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM categories
        WHERE slug = ?
        LIMIT 1
    ");

    $stmt->execute([$slug]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| All Products
|--------------------------------------------------------------------------
*/

function getProducts()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT
            p.*,
            c.name AS category_name,
            c.slug AS category_slug
        FROM products p
        LEFT JOIN categories c
            ON c.id = p.category_id
        WHERE p.status = 1
        ORDER BY p.id DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Featured Products
|--------------------------------------------------------------------------
*/

function getFeaturedProducts()
{
    global $pdo;

    $stmt = $pdo->query("
        SELECT
            p.*,
            c.name AS category_name,
            c.slug AS category_slug
        FROM products p
        LEFT JOIN categories c
            ON c.id = p.category_id
        WHERE
            p.status = 1
            AND p.featured = 1
        ORDER BY p.id DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Latest Products
|--------------------------------------------------------------------------
*/

function getLatestProducts($limit = 8)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT
            p.*,
            c.name AS category_name,
            c.slug AS category_slug
        FROM products p
        LEFT JOIN categories c
            ON c.id = p.category_id
        WHERE p.status = 1
        ORDER BY p.id DESC
        LIMIT ?
    ");

    $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Product By ID
|--------------------------------------------------------------------------
*/

function getProduct($id)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT
            p.*,
            c.name AS category_name,
            c.slug AS category_slug
        FROM products p
        LEFT JOIN categories c
            ON c.id = p.category_id
        WHERE p.id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Product By Slug
|--------------------------------------------------------------------------
*/

function getProductBySlug($slug)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT
            p.*,
            c.name AS category_name,
            c.slug AS category_slug
        FROM products p
        LEFT JOIN categories c
            ON c.id = p.category_id
        WHERE
            p.slug = ?
            AND p.status = 1
        LIMIT 1
    ");

    $stmt->execute([$slug]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Products By Category
|--------------------------------------------------------------------------
*/

function getProductsByCategory($categoryId)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM products
        WHERE
            category_id = ?
            AND status = 1
        ORDER BY id DESC
    ");

    $stmt->execute([$categoryId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Product Images
|--------------------------------------------------------------------------
*/

function getProductImages($productId)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM product_images
        WHERE product_id = ?
        ORDER BY sort_order ASC
    ");

    $stmt->execute([$productId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Thumbnail
|--------------------------------------------------------------------------
*/

function getProductThumbnail($productId)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM product_images
        WHERE
            product_id = ?
            AND is_thumbnail = 1
        LIMIT 1
    ");

    $stmt->execute([$productId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Product Size
|--------------------------------------------------------------------------
*/

function getProductSize($productId)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM product_sizes
        WHERE product_id = ?
        LIMIT 1
    ");

    $stmt->execute([$productId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Product Features
|--------------------------------------------------------------------------
*/

function getProductFeatures($productId)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM product_features
        WHERE product_id = ?
        ORDER BY id ASC
    ");

    $stmt->execute([$productId]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
|--------------------------------------------------------------------------
| Product SEO
|--------------------------------------------------------------------------
*/

function getProductSEO($productId)
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT *
        FROM product_seo
        WHERE product_id = ?
        LIMIT 1
    ");

    $stmt->execute([$productId]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}