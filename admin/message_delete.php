<?php

session_start();

require_once "../config/database.php";


/*
|--------------------------------------------------------------------------
| Check Admin Login
|--------------------------------------------------------------------------
*/

if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Get Message ID
|--------------------------------------------------------------------------
*/

$id = intval(
    $_GET["id"] ?? 0
);


if ($id <= 0) {

    header("Location: messages.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Delete Message
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,

    "DELETE FROM messages
     WHERE id = ?"
);


if (!$stmt) {

    die(
        "Database preparation failed: "
        . mysqli_error($conn)
    );

}


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);


mysqli_stmt_execute($stmt);


mysqli_stmt_close($stmt);


/*
|--------------------------------------------------------------------------
| Return To Messages
|--------------------------------------------------------------------------
*/

header("Location: messages.php");

exit;

?>