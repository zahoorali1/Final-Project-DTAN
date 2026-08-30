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

    header("Location: gallery.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Get Image
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,

    "SELECT image
     FROM gallery
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


$gallery =
    mysqli_fetch_assoc($result);


mysqli_stmt_close($stmt);


/*
|--------------------------------------------------------------------------
| Delete Database Record
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,

    "DELETE FROM gallery
     WHERE id = ?"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


if (
    mysqli_stmt_execute($stmt)
) {


    /*
    |--------------------------------------------------------------------------
    | Delete Physical Image
    |--------------------------------------------------------------------------
    */

    if (
        $gallery &&
        !empty($gallery["image"]) &&
        file_exists(
            "../" . $gallery["image"]
        )
    ) {

        unlink(
            "../" . $gallery["image"]
        );

    }

}


mysqli_stmt_close($stmt);


header("Location: gallery.php");

exit;

?>