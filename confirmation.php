<?php

require_once "config/database.php";

$pageTitle = "Order Confirmation | Elegance Boutique";


// ==========================================
// GET ORDER ID
// ==========================================

$orderId = intval($_GET["order_id"] ?? 0);

if ($orderId <= 0) {
    die("Invalid order.");
}


// ==========================================
// GET ORDER + ORDER ITEM + PRODUCT
// ==========================================

$sql = "
    SELECT
        o.id AS order_id,
        o.customer_name,
        o.phone,
        o.address,
        o.total_amount,
        o.status,
        o.created_at,

        oi.quantity,
        oi.price,
        oi.subtotal,

        p.name AS product_name,
        p.image AS product_image

    FROM orders o

    INNER JOIN order_items oi
        ON o.id = oi.order_id

    INNER JOIN products p
        ON oi.product_id = p.id

    WHERE o.id = ?

    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database error.");
}

mysqli_stmt_bind_param($stmt, "i", $orderId);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$order = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


// ==========================================
// CHECK ORDER
// ==========================================

if (!$order) {
    die("Order not found.");
}


include "includes/header.php";

?>


<section class="section confirmation-section">

    <div class="confirmation-container">

        <!-- SUCCESS MESSAGE -->

        <div class="confirmation-header">

            <div class="confirmation-icon">
                ✓
            </div>

            <p class="eyebrow">
                Order Successfully Placed
            </p>

            <h1>
                Thank You, <?= htmlspecialchars($order["customer_name"]) ?>!
            </h1>

            <p class="confirmation-message">
                Your order has been received successfully.
                We will contact you shortly to confirm your order.
            </p>

        </div>


        <!-- ORDER INFORMATION -->

        <div class="order-info">

            <div class="order-info-item">

                <span>Order Number</span>

                <strong>
                    #<?= $order["order_id"] ?>
                </strong>

            </div>


            <div class="order-info-item">

                <span>Order Status</span>

                <strong>
                    <?= htmlspecialchars($order["status"]) ?>
                </strong>

            </div>


            <div class="order-info-item">

                <span>Order Date</span>

                <strong>
                    <?= date(
                        "d M Y, h:i A",
                        strtotime($order["created_at"])
                    ) ?>
                </strong>

            </div>

        </div>


        <!-- CUSTOMER DETAILS -->

        <div class="confirmation-card">

            <h2>
                Customer Information
            </h2>

            <div class="customer-details">

                <p>
                    <strong>Name:</strong>
                    <?= htmlspecialchars($order["customer_name"]) ?>
                </p>

                <p>
                    <strong>Phone:</strong>
                    <?= htmlspecialchars($order["phone"]) ?>
                </p>

                <p>
                    <strong>Delivery Address:</strong>
                    <?= nl2br(
                        htmlspecialchars($order["address"])
                    ) ?>
                </p>

            </div>

        </div>


        <!-- PRODUCT DETAILS -->

        <div class="confirmation-card">

            <h2>
                Order Details
            </h2>

            <div class="confirmation-product">

                <?php if (!empty($order["product_image"])): ?>

<img
    src="<?= htmlspecialchars($order["product_image"]) ?>"
    alt="<?= htmlspecialchars($order["product_name"]) ?>"
>

                <?php endif; ?>


                <div class="confirmation-product-info">

                    <h3>
                        <?= htmlspecialchars($order["product_name"]) ?>
                    </h3>

                    <p>
                        Price:
                        Rs. <?= number_format(
                            $order["price"],
                            2
                        ) ?>
                    </p>

                    <p>
                        Quantity:
                        <?= $order["quantity"] ?>
                    </p>

                    <p>
                        Subtotal:
                        <strong>
                            Rs. <?= number_format(
                                $order["subtotal"],
                                2
                            ) ?>
                        </strong>
                    </p>

                </div>

            </div>


            <div class="order-total">

                <span>
                    Total Amount
                </span>

                <strong>
                    Rs. <?= number_format(
                        $order["total_amount"],
                        2
                    ) ?>
                </strong>

            </div>

        </div>


        <!-- ACTION BUTTONS -->

        <div class="confirmation-actions">

            <a
                href="products.php"
                class="btn view-btn"
            >
                Continue Shopping
            </a>

            <a
                href="index.php"
                class="btn order-btn"
            >
                Back to Home
            </a>

        </div>

    </div>

</section>


<?php include "includes/footer.php"; ?>