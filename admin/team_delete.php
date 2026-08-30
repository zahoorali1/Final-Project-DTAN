<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit;
}


/* Get image before deleting */

$stmt = mysqli_prepare(
    $conn,
    "SELECT image FROM team WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$member = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


/* Delete database record */

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM team WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);


/* Delete image */

if (
    $member &&
    !empty($member["image"])
) {

    $imagePath =
        "../../uploads/team/" .
        $member["image"];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}


header("Location: index.php");

exit;