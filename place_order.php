<?php

require_once "config/database.php";


// ==========================================
// ONLY ALLOW POST REQUEST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: products.php");
    exit;
}


// ==========================================
// GET CUSTOMER DATA
// ==========================================

$customerName = trim($_POST["customer_name"] ?? "");
$phone        = trim($_POST["phone"] ?? "");
$address      = trim($_POST["address"] ?? "");

$productId = intval($_POST["product_id"] ?? 0);
$quantity  = intval($_POST["quantity"] ?? 0);


// ==========================================
// VALIDATE DATA
// ==========================================

if (
    $customerName === "" ||
    $phone === "" ||
    $address === "" ||
    $productId <= 0 ||
    $quantity <= 0
) {
    die("Please provide all required information.");
}


// ==========================================
// GET PRODUCT FROM DATABASE
// ==========================================

$sql = "
    SELECT id, name, price
    FROM products
    WHERE id = ?
    LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Database error.");
}

mysqli_stmt_bind_param($stmt, "i", $productId);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$product = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


// ==========================================
// CHECK PRODUCT
// ==========================================

if (!$product) {
    die("Product not found.");
}


// ==========================================
// GET PRICE FROM DATABASE
// ==========================================

$price = (float) $product["price"];


// ==========================================
// CALCULATE SUBTOTAL
// ==========================================

$subtotal = $price * $quantity;


// ==========================================
// START DATABASE TRANSACTION
// ==========================================

mysqli_begin_transaction($conn);


try {

    // ======================================
    // CREATE ORDER
    // ======================================

    $orderSql = "
        INSERT INTO orders
        (
            customer_name,
            phone,
            address,
            total_amount,
            status
        )
        VALUES (?, ?, ?, ?, 'Pending')
    ";

    $orderStmt = mysqli_prepare($conn, $orderSql);

    if (!$orderStmt) {
        throw new Exception("Could not create order.");
    }

    mysqli_stmt_bind_param(
        $orderStmt,
        "sssd",
        $customerName,
        $phone,
        $address,
        $subtotal
    );

    if (!mysqli_stmt_execute($orderStmt)) {
        throw new Exception("Could not save order.");
    }


    // ======================================
    // GET NEW ORDER ID
    // ======================================

    $orderId = mysqli_insert_id($conn);

    mysqli_stmt_close($orderStmt);


    // ======================================
    // CREATE ORDER ITEM
    // ======================================

    $itemSql = "
        INSERT INTO order_items
        (
            order_id,
            product_id,
            quantity,
            price,
            subtotal
        )
        VALUES (?, ?, ?, ?, ?)
    ";

    $itemStmt = mysqli_prepare($conn, $itemSql);

    if (!$itemStmt) {
        throw new Exception("Could not create order item.");
    }

    mysqli_stmt_bind_param(
        $itemStmt,
        "iiidd",
        $orderId,
        $productId,
        $quantity,
        $price,
        $subtotal
    );

    if (!mysqli_stmt_execute($itemStmt)) {
        throw new Exception("Could not save order item.");
    }

    mysqli_stmt_close($itemStmt);


    // ======================================
    // COMMIT TRANSACTION
    // ======================================

    mysqli_commit($conn);


    // ======================================
    // REDIRECT TO CONFIRMATION
    // ======================================

    header(
        "Location: confirmation.php?order_id=" . $orderId
    );

    exit;


} catch (Exception $e) {

    // ======================================
    // ROLLBACK IF SOMETHING FAILS
    // ======================================

    mysqli_rollback($conn);

    die("Order could not be placed. Please try again.");

}