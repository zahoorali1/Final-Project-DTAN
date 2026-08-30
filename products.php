<?php

require_once "config/database.php";

$pageTitle = "Products | Elegance Boutique";


// --------------------------------------------------
// Selected Category
// --------------------------------------------------

$categoryId = (int) ($_GET['category'] ?? 0);


// --------------------------------------------------
// Get Products
// --------------------------------------------------

if ($categoryId > 0) {

    $sql = "
        SELECT 
            p.*,
            c.name AS category_name
        FROM products p
        LEFT JOIN categories c
            ON p.category_id = c.id
        WHERE c.id = ?
        ORDER BY p.id DESC
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        die("Database error: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "i", $categoryId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

} else {

    $sql = "
        SELECT 
            p.*,
            c.name AS category_name
        FROM products p
        LEFT JOIN categories c
            ON p.category_id = c.id
        ORDER BY p.id DESC
    ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Database error: " . mysqli_error($conn));
    }

}


$products = [];

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $products[] = $row;

    }

}


// --------------------------------------------------
// Get Categories
// --------------------------------------------------

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

// --------------------------------------------------
// Header
// --------------------------------------------------

include "includes/header.php";

?>


<!-- ==================================================
     PAGE BANNER
================================================== -->

<section class="page-banner">

    <p class="eyebrow">
        COLLECTION
    </p>

    <h1>
        Our Products
    </h1>

    <p>
        Find pieces for everyday moments
        and special occasions.
    </p>

</section>



<!-- ==================================================
     PRODUCTS SECTION
================================================== -->

<section class="section">


    <!-- ==================================================
         CATEGORY FILTER
    ================================================== -->

    <div class="filters">

        <!-- All Products -->

        <a
            href="products.php"
            class="<?= $categoryId === 0 ? 'active' : '' ?>"
        >
            All
        </a>


        <!-- Categories -->

        <?php foreach ($categories as $cat): ?>

            <a
                href="products.php?category=<?= (int) $cat['id'] ?>"
                class="<?= $categoryId === (int) $cat['id'] ? 'active' : '' ?>"
            >
                <?= htmlspecialchars($cat['name']) ?>
            </a>

        <?php endforeach; ?>

    </div>



    <!-- ==================================================
         PRODUCTS GRID
    ================================================== -->

    <div class="product-grid">

        <?php if (count($products) > 0): ?>


            <?php foreach ($products as $product): ?>


                <!-- ==================================================
                     PRODUCT CARD
                ================================================== -->

                <article class="product-card">


                    <!-- Product Image -->

                <div class="product-image">
                    <img
                        src="<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>"
                    >
                </div>


                    <!-- Product Information -->

                    <div class="product-info">


                        <!-- Category -->

                    <p class="small">

                        <?= htmlspecialchars($product['category_name'] ?? 'Uncategorized') ?>

                    </p>


                        <!-- Product Name -->

                        <h3>

                            <?= htmlspecialchars($product['name']) ?>

                        </h3>


                        <!-- Description -->

<div class="product-description-text">

    <?php
    $description = htmlspecialchars($product['description']);
    $shortDescription = mb_substr($product['description'], 0, 90);
    ?>

    <span class="description-short">
        <?= htmlspecialchars($shortDescription) ?>

        <?php if (mb_strlen($product['description']) > 90): ?>
            ...
        <?php endif; ?>
    </span>

    <?php if (mb_strlen($product['description']) > 90): ?>

        <span class="description-full" hidden>
            <?= $description ?>
        </span>

    <button
        type="button"
        class="read-more-btn"
        onclick="toggleProductDescription(this)"
        aria-expanded="false"
    >
        Read More
    </button>

    <?php endif; ?>

</div>


                        <!-- Price -->

                        <strong>

                            Rs.

                            <?= number_format($product['price']) ?>

                        </strong>



                        <!-- ==================================================
                             PRODUCT BUTTONS
                        ================================================== -->

                        <div class="product-buttons">


                            <!-- View Details -->

                            <a
                                href="product_details.php?id=<?= $product['id'] ?>"
                                class="btn view-btn"
                            >
                                View Details
                            </a>


                            <!-- Contact Us to Order -->

                            <!-- <a
                                href="contact.php?product=<?= urlencode($product['name']) ?>"
                                class="btn order-btn"
                            >
                                Contact Us to Order
                            </a> -->
                            <a
                                href="checkout.php?id=<?= $product['id'] ?>"
                                class="btn order-btn"
                            >
                                Buy Now
                            </a>


                        </div>


                    </div>


                </article>


            <?php endforeach; ?>


        <?php else: ?>


            <!-- No Products -->

            <p>

                No products found in this category.

            </p>


        <?php endif; ?>


    </div>


</section>



<!-- ==================================================
     FOOTER
================================================== -->

<?php

include "includes/footer.php";

?>

<script>
function toggleProductDescription(button) {
    const descriptionBox = button.closest(".product-description-text");
    if (!descriptionBox) return;
    const shortText = descriptionBox.querySelector(".description-short");
    const fullText = descriptionBox.querySelector(".description-full");
    if (!shortText || !fullText) return;
    const isExpanded = descriptionBox.classList.toggle("is-expanded");
    shortText.hidden = isExpanded;
    fullText.hidden = !isExpanded;
    button.textContent = isExpanded ? "Read Less" : "Read More";
    button.setAttribute("aria-expanded", String(isExpanded));
}
</script>