<?php

session_start();

require_once "../config/database.php";


if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");
    exit;

}


$id = intval(
    $_GET["id"] ?? 0
);


if ($id <= 0) {

    header("Location: products.php");
    exit;

}


// Get image first

$stmt = mysqli_prepare(
    $conn,

    "SELECT image
     FROM products
     WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result =
    mysqli_stmt_get_result($stmt);

$product =
    mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


// Delete product

$stmt = mysqli_prepare(
    $conn,

    "DELETE FROM products
     WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


if (mysqli_stmt_execute($stmt)) {


    // Delete image from server

    if (
        $product &&
        !empty($product["image"]) &&
        file_exists(
            "../" . $product["image"]
        )
    ) {

        unlink(
            "../" . $product["image"]
        );

    }

}


mysqli_stmt_close($stmt);


header("Location: products.php");

exit;

?>