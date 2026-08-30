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


$pageTitle = "Orders";
$successMessage = "";
$errorMessage = "";


// ==========================================
// GENERATE CSRF TOKEN
// ==========================================

if (empty($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}


// ==========================================
// UPDATE ORDER STATUS
// ==========================================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Verify CSRF token
    if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"] ?? "")) {
        $errorMessage = "Invalid security token. Please try again.";
    } else {

        $orderId = intval($_POST["order_id"] ?? 0);
        $status  = trim($_POST["status"] ?? "");

        if ($orderId > 0 && in_array($status, ALLOWED_STATUSES, true)) {

            $sql = "
                UPDATE orders
                SET status = ?
                WHERE id = ?
            ";

            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {

                mysqli_stmt_bind_param(
                    $stmt,
                    "si",
                    $status,
                    $orderId
                );

                if (mysqli_stmt_execute($stmt)) {
                    $successMessage = "Order status updated successfully.";
                } else {
                    $errorMessage = "Failed to update order status.";
                }

                mysqli_stmt_close($stmt);

            } else {
                $errorMessage = "Database error: " . mysqli_error($conn);
            }

        } else {
            $errorMessage = "Invalid order ID or status.";
        }
    }

    // Don't redirect immediately if there's an error
    if ($errorMessage) {
        // Show error on current page
    } else {
        header("Location: orders.php");
        exit;
    }
}


// ==========================================
// GET ALL ORDERS
// ==========================================

$sql = "
    SELECT
        id,
        customer_name,
        phone,
        address,
        total_amount,
        status,
        created_at

    FROM orders

    ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

$orders = [];

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {
        $orders[] = $row;
    }

} else {
    $errorMessage = "Failed to fetch orders: " . mysqli_error($conn);
}




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
        Dashboard | Elegance Boutique
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


            <a
                href="dashboard.php"
                class="active"
            >

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
                    Orders
                </h1>

            </div>

        </div>


        <?php if ($successMessage): ?>
            <div class="admin-alert success-alert">
                <?= htmlspecialchars($successMessage) ?>
            </div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="admin-alert error-alert">
                <?= htmlspecialchars($errorMessage) ?>
            </div>
        <?php endif; ?>


        <?php if (empty($orders)): ?>

            <div class="admin-empty">

                <h3>
                    No Orders Yet
                </h3>

                <p>
                    Customer orders will appear here once they
                    place an order.
                </p>

            </div>

        <?php else: ?>

            <div class="admin-table-wrapper">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>
                            Order
                        </th>

                        <th>
                            Customer
                        </th>

                        <th>
                            Phone
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php foreach ($orders as $order): ?>

                        <tr>

                            <!-- ORDER ID -->

                            <td>

                                <strong>
                                    #<?= $order["id"] ?>
                                </strong>

                            </td>


                            <!-- CUSTOMER -->

                            <td>

                                <?= htmlspecialchars(
                                    $order["customer_name"]
                                ) ?>

                            </td>


                            <!-- PHONE -->

                            <td>

                                <?= htmlspecialchars(
                                    $order["phone"]
                                ) ?>

                            </td>


                            <!-- TOTAL -->

                            <td>

                                Rs.
                                <?= number_format(
                                    $order["total_amount"],
                                    2
                                ) ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <span
                                    class="order-status status-<?= strtolower(
                                        $order["status"]
                                    ) ?>"
                                >

                                    <?= htmlspecialchars(
                                        $order["status"]
                                    ) ?>

                                </span>

                            </td>


                            <!-- DATE -->

                            <td>

                                <?= date(
                                    "d M Y",
                                    strtotime(
                                        $order["created_at"]
                                    )
                                ) ?>

                            </td>


                            <!-- ACTION -->

                            <td>

                                <div class="order-actions">

                                    <a
                                        href="order_view.php?id=<?= $order["id"] ?>"
                                        class="admin-btn view-btn"
                                    >
                                        View
                                    </a>


                                    <form
                                        method="POST"
                                        class="status-form"
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
                                            onchange="this.form.submit()"
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

                                    </form>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

        <?php endif; ?>

    </div><!-- .admin-main -->

</div><!-- .admin-layout -->


