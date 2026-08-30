<?php

require_once __DIR__ . "/config/database.php";

$pageTitle = "Elegance Boutique | Home";

if (!$conn) {
    die("CONNECTION VARIABLE DOES NOT EXIST");
}
// ==========================================
// GET FEATURED PRODUCTS
// ==========================================

$sql = "
    SELECT 
        p.*,
        c.name AS category
    FROM products p
    LEFT JOIN categories c
        ON p.category_id = c.id
    WHERE p.featured = 1
    ORDER BY p.id DESC
    LIMIT 4
";

$result = mysqli_query($conn, $sql);

$featuredProducts = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $featuredProducts[] = $row;
    }
}


// ==========================================
// GET CATEGORIES
// ==========================================

$sql = "
    SELECT *
    FROM categories
    ORDER BY name
";

$result = mysqli_query($conn, $sql);

$categories = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}
$sql = "
    SELECT 
        c.id,
        c.name,
        (
            SELECT p.image
            FROM products p
            WHERE p.category_id = c.id
            LIMIT 1
        ) AS image
    FROM categories c
    ORDER BY c.id
";

$result = mysqli_query($conn, $sql);



$categories = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
}

// ==========================================
// HEADER
// ==========================================

include "includes/header.php";

?>


<!-- ==========================================
     HERO
========================================== -->

<section class="hero">

    <div class="hero-content">

        <p class="eyebrow">
            ELEGANCE BOUTIQUE
        </p>

        <h1>
            Discover Your
            <br>
            <span>Signature Style</span>
        </h1>

        <p>
            Timeless clothing,
            thoughtfully selected
            for modern confidence.
        </p>

        <a
            href="products.php"
            class="btn"
        >
            Shop Collection
        </a>

    </div>

</section>


<!-- ==========================================
     CATEGORIES
========================================== -->

<section class="section">

    <div class="section-title">

        <p class="eyebrow">
            EXPLORE
        </p>

        <h2>
            Shop by Category
        </h2>

    </div>


    <div class="category-grid">

<?php foreach ($categories as $category): ?>

    <a
        href="products.php?category=<?= urlencode($category['name']) ?>"
        class="category-card"
    >

        <?php if (!empty($category['image'])): ?>

            <img
                src="<?= htmlspecialchars($category['image']) ?>"
                alt="<?= htmlspecialchars($category['name']) ?>"
            >

        <?php else: ?>

            <div class="category-no-image">
                No Image
            </div>

        <?php endif; ?>

        <span>
            <?= htmlspecialchars($category['name']) ?>
        </span>

    </a>

<?php endforeach; ?>

    </div>

</section>


<!-- ==========================================
     FEATURED PRODUCTS
========================================== -->

<section class="section muted">

    <div class="section-title">

        <p class="eyebrow">
            CURATED FOR YOU
        </p>

        <h2>
            Featured Collection
        </h2>

    </div>


    <div class="product-grid">

        <?php foreach ($featuredProducts as $product): ?>

            <article class="product-card">

                <img
                    src="<?= htmlspecialchars($product['image']) ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                >

                <div class="product-info">

                    <p class="small">
                        <?= htmlspecialchars($product['category']) ?>
                    </p>

                    <h3>
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>

                    <strong>
                        Rs.
                        <?= number_format($product['price']) ?>
                    </strong>

                </div>

            </article>

        <?php endforeach; ?>

    </div>

</section>


<!-- ==========================================
     PROMOTION
========================================== -->

<section class="promo">

    <div>

        <p class="eyebrow">
            LIMITED OFFER
        </p>

        <h2>
            20% Off Our New Collection
        </h2>

        <p>
            Refresh your wardrobe with
            selected new-season pieces.
        </p>

    </div>


    <a
        href="products.php"
        class="btn light"
    >
        View Collection
    </a>

</section>


<?php

include "includes/footer.php";

?>