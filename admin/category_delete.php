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

    header("Location: categories.php");
    exit;

}


// Check whether products use this category

$stmt = mysqli_prepare(
    $conn,

    "SELECT COUNT(*) AS total
     FROM products
     WHERE category_id = ?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result =
    mysqli_stmt_get_result($stmt);

$data =
    mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if ($data["total"] > 0) {

    $_SESSION["category_error"] =
        "This category cannot be deleted because products are using it.";

    header("Location: categories.php");

    exit;

}


// Delete category

$stmt = mysqli_prepare(
    $conn,

    "DELETE FROM categories
     WHERE id = ?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


mysqli_stmt_execute($stmt);


mysqli_stmt_close($stmt);


header("Location: categories.php");

exit;

?>