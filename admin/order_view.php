<?php

session_start();

require_once "../config/database.php";


// ==========================================
// CHECK ADMIN LOGIN
// ==========================================

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}


// ==========================================
// GENERATE CSRF TOKEN
// ==========================================

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}


// ==========================================
// GET ORDER ID
// ==========================================

$orderId = intval($_GET["id"] ?? 0);

if ($orderId <= 0) {
    header("Location: orders.php");
    exit;
}


// ==========================================
// GET ORDER INFORMATION
// ==========================================

$orderSql = "
    SELECT
        id,
        customer_name,
        phone,
        address,
        total_amount,
        status,
        created_at
    FROM orders
    WHERE id = ?
    LIMIT 1
";

$orderStmt = mysqli_prepare($conn, $orderSql);

if (!$orderStmt) {
    die("Database error.");
}

mysqli_stmt_bind_param(
    $orderStmt,
    "i",
    $orderId
);

mysqli_stmt_execute($orderStmt);

$orderResult = mysqli_stmt_get_result($orderStmt);

$order = mysqli_fetch_assoc($orderResult);

mysqli_stmt_close($orderStmt);


// ==========================================
// CHECK ORDER
// ==========================================

if (!$order) {
    $orderNotFound = true;
} else {
    $orderNotFound = false;
    
    // ==========================================
    // GET ORDER ITEMS
    // ==========================================
    
    $itemsSql = "
        SELECT
            oi.id,
            oi.quantity,
            oi.price,
            oi.subtotal,

            p.name AS product_name,
            p.image AS product_image

        FROM order_items oi

        INNER JOIN products p
            ON oi.product_id = p.id

        WHERE oi.order_id = ?

        ORDER BY oi.id ASC
    ";

    $itemsStmt = mysqli_prepare($conn, $itemsSql);

    if (!$itemsStmt) {
        die("Database error.");
    }

    mysqli_stmt_bind_param(
        $itemsStmt,
        "i",
        $orderId
    );

    mysqli_stmt_execute($itemsStmt);

    $itemsResult = mysqli_stmt_get_result($itemsStmt);

    $items = [];

    while ($row = mysqli_fetch_assoc($itemsResult)) {

        $items[] = $row;

    }

    mysqli_stmt_close($itemsStmt);
}


// ==========================================
// DEFINE ALLOWED STATUSES
// ==========================================

const ALLOWED_STATUSES = [
    "Pending",
    "Confirmed",
    "Processing",
    "Shipped",
    "Delivered",
    "Cancelled"
];


$pageTitle = $orderNotFound ? "Order Not Found" : "Order #" . $order["id"];

?>
<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= $pageTitle ?> | Elegance Boutique
    </title>

    <link
        rel="stylesheet"
        href="admin.css"
    >

</head>

<body>

</body>

<div class="admin-layout">


    <!-- SIDEBAR -->

    <aside class="sidebar">


        <div class="admin-logo">

            <a href="../index.php">

                ELEGANCE

                <span>
                    BOUTIQUE
                </span>

            </a>

        </div>


        <nav class="sidebar-nav">


            <a href="dashboard.php">

                <span>▣</span>

                Dashboard

            </a>


            <a href="products.php">

                <span>◈</span>

                Products

            </a>


            <a href="categories.php">

                <span>◇</span>

                Categories

            </a>


            <a href="gallery.php">

                <span>▧</span>

                Gallery

            </a>


            <!-- TEAM -->

            <a href="team.php">

                <span>♙</span>

                Team

            </a>


            <a href="messages.php">

                <span>✉</span>

                Messages

            </a>
<a href="orders.php">
    <span>🛍</span>
    Orders
</a>

        </nav>


        <div class="sidebar-bottom">


            <a
                href="../index.php"
                target="_blank"
            >

                View Website

            </a>


            <a href="logout.php">

                Logout

            </a>


        </div>


    </aside>

    <div class="admin-main">

        <div class="admin-page-header">

            <div>

                <p class="eyebrow">
                    Order Management
                </p>

                <h1>
                    <?php if ($orderNotFound): ?>
                        Order Not Found
                    <?php else: ?>
                        Order #<?= $order["id"] ?>
                    <?php endif; ?>
                </h1>

            </div>

            <a
                href="orders.php"
                class="back-orders-btn"
            >
                ← Back to Orders
            </a>

        </div>


        <?php if ($orderNotFound): ?>

            <div class="admin-empty">

                <h3>
                    Order Not Found
                </h3>

                <p>
                    The order you're looking for doesn't exist. Please check the order ID and try again.
                </p>

                <a href="orders.php" class="admin-btn" style="margin-top: 20px;">
                    View All Orders
                </a>

            </div>

        <?php else: ?>

            <!-- =====================================
                 CUSTOMER INFORMATION
            ====================================== -->

            <div class="order-view-grid">

                <div class="admin-card">

                    <h2>
                        Customer Information
                    </h2>


                    <div class="order-detail">

                        <span>
                            Customer Name
                        </span>

                        <strong>
                            <?= htmlspecialchars(
                                $order["customer_name"]
                            ) ?>
                        </strong>

                    </div>


                    <div class="order-detail">

                        <span>
                            Phone
                        </span>

                        <strong>
                            <?= htmlspecialchars(
                                $order["phone"]
                            ) ?>
                        </strong>

                    </div>


                    <div class="order-detail">

                        <span>
                            Delivery Address
                        </span>

                        <strong>
                            <?= nl2br(
                                htmlspecialchars(
                                    $order["address"]
                                )
                            ) ?>
                        </strong>

                    </div>

                </div>


                <!-- =================================
                     ORDER INFORMATION
                ================================== -->

                <div class="admin-card">

                    <h2>
                        Order Information
                    </h2>


                    <div class="order-detail">

                        <span>
                            Order Number
                        </span>

                        <strong>
                            #<?= $order["id"] ?>
                        </strong>

                    </div>


            <div class="order-detail">

                <span>
                    Order Date
                </span>

                <strong>
                    <?= date(
                        "d M Y, h:i A",
                        strtotime(
                            $order["created_at"]
                        )
                    ) ?>
                </strong>

            </div>


            <div class="order-detail">

                <span>
                    Status
                </span>

                <span
                    class="order-status status-<?= strtolower(
                        $order["status"]
                    ) ?>"
                >
                    <?= htmlspecialchars(
                        $order["status"]
                    ) ?>
                </span>

            </div>


            <div class="order-detail">

                <span>
                    Total Amount
                </span>

                <strong class="order-total-value">
                    Rs.
                    <?= number_format(
                        $order["total_amount"],
                        2
                    ) ?>
                </strong>

            </div>

        </div>

    </div>


    <!-- =====================================
         ORDER ITEMS
    ====================================== -->

    <div class="admin-card order-items-card">

        <h2>
            Ordered Products
        </h2>


        <?php if (empty($items)): ?>

            <p>
                No products found for this order.
            </p>

        <?php else: ?>

            <div class="admin-table-wrapper">

                <table class="admin-table">

                    <thead>

                        <tr>

                            <th>
                                Product
                            </th>

                            <th>
                                Price
                            </th>

                            <th>
                                Quantity
                            </th>

                            <th>
                                Subtotal
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php foreach ($items as $item): ?>

                            <tr>

                                <!-- PRODUCT -->

                                <td>

<div class="order-product">

    <?php if (!empty($item["product_image"])): ?>

    <img
        src="/project/<?= htmlspecialchars(ltrim($item["product_image"], "/")) ?>"
        alt="<?= htmlspecialchars($item["product_name"] ?? "Product") ?>"
        style="width:70px; height:70px; object-fit:cover;"
        onerror="this.style.display='none';"
    >

<?php endif; ?>

    <strong>
        <?= htmlspecialchars($item["product_name"]) ?>
    </strong>

</div>

                                </td>


                                <!-- PRICE -->

                                <td>

                                    Rs.
                                    <?= number_format(
                                        $item["price"],
                                        2
                                    ) ?>

                                </td>


                                <!-- QUANTITY -->

                                <td>

                                    <?= $item["quantity"] ?>

                                </td>


                                <!-- SUBTOTAL -->

                                <td>

                                    <strong>

                                        Rs.
                                        <?= number_format(
                                            $item["subtotal"],
                                            2
                                        ) ?>

                                    </strong>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>


                    <tfoot>

                        <tr>

                            <td
                                colspan="3"
                                style="text-align: right;"
                            >

                                <strong>
                                    Total
                                </strong>

                            </td>

                            <td>

                                <strong class="order-total-value">

                                    Rs.
                                    <?= number_format(
                                        $order["total_amount"],
                                        2
                                    ) ?>

                                </strong>

                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        <?php endif; ?>

    </div>


    <!-- =====================================
         ORDER STATUS UPDATE
    ====================================== -->

    <div class="admin-card">

        <h2>
            Update Order Status
        </h2>


        <form
            action="orders.php"
            method="POST"
            class="order-status-update"
            onsubmit="return confirm('Update order status?')"
        >

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($_SESSION["csrf_token"]) ?>"
            >

            <input
                type="hidden"
                name="order_id"
                value="<?= $order["id"] ?>"
            >


            <select
                name="status"
                required
                title="Update order status"
            >

                <?php foreach (ALLOWED_STATUSES as $status): ?>

                    <option
                        value="<?= $status ?>"
                        <?= $order["status"] === $status
                            ? "selected"
                            : "" ?>
                    >
                        <?= $status ?>
                    </option>

                <?php endforeach; ?>

            </select>


            <button
                type="submit"
                class="admin-btn"
            >
                Update Status
            </button>

        </form>

    </div>

        <?php endif; ?>

    </div><!-- .admin-main -->

</div><!-- .admin-layout -->

