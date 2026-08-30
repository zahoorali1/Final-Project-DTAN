<?php

require_once "config/database.php";

$pageTitle = "Product Details | Elegance Boutique";


// --------------------------------------------------
// Get Product ID
// --------------------------------------------------

$id = intval($_GET['id'] ?? 0);


// --------------------------------------------------
// Validate Product ID
// --------------------------------------------------

if ($id <= 0) {

    header("Location: products.php");
    exit;

}


// --------------------------------------------------
// Get Product
// --------------------------------------------------

$sql = "
    SELECT *
    FROM products
    WHERE id = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);


// --------------------------------------------------
// Product Not Found
// --------------------------------------------------

if (!$product) {

    header("Location: products.php");
    exit;

}


// --------------------------------------------------
// Header
// --------------------------------------------------

include "includes/header.php";

?>


<!-- ==================================================
     PRODUCT DETAILS
================================================== -->

<section class="product-details-section">

    <div class="product-details-container">


        <!-- ==================================================
             PRODUCT IMAGE
        ================================================== -->

        <div class="product-details-image">

            <img
                src="<?= htmlspecialchars($product['image']) ?>"
                alt="<?= htmlspecialchars($product['name']) ?>"
            >

        </div>



        <!-- ==================================================
             PRODUCT INFORMATION
        ================================================== -->

        <div class="product-details-info">


            <!-- Category -->

            <p class="product-category">

                <?= htmlspecialchars($product['category']) ?>

            </p>


            <!-- Product Name -->

            <h1>

                <?= htmlspecialchars($product['name']) ?>

            </h1>


            <!-- Price -->

            <p class="product-price">

                Rs.

                <?= number_format($product['price']) ?>

            </p>


            <!-- Description -->

            <div class="product-description">

                <h3>
                    Description
                </h3>

                <p>

                    <?= nl2br(htmlspecialchars($product['description'])) ?>

                </p>

            </div>


            <!-- ==================================================
                 BUTTONS
            ================================================== -->

            <div class="product-detail-buttons">


                <!-- Contact Us to Order -->

                <a
                    href="contact.php?product=<?= urlencode($product['name']) ?>"
                    class="btn order-btn"
                >
                    Contact Us to Order
                </a>


                <!-- Back to Products -->

                <a
                    href="products.php"
                    class="btn back-btn"
                >
                    Back to Products
                </a>


            </div>


        </div>


    </div>

</section>


<?php

include "includes/footer.php";

?>