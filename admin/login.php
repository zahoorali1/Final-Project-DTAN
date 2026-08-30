<?php

session_start();

require_once "../config/database.php";


// If already logged in
if (isset($_SESSION["admin_id"])) {

    header("Location: dashboard.php");
    exit;

}


$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");

    $password = $_POST["password"] ?? "";


    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } else {

        $stmt = mysqli_prepare(
            $conn,
            "SELECT id, name, email, password, role
             FROM users
             WHERE email = ?
             LIMIT 1"
        );


        mysqli_stmt_bind_param(
            $stmt,
            "s",
            $email
        );


        mysqli_stmt_execute($stmt);


        $result = mysqli_stmt_get_result($stmt);


        if ($result && mysqli_num_rows($result) === 1) {

            $user = mysqli_fetch_assoc($result);


            if (
                password_verify(
                    $password,
                    $user["password"]
                )
            ) {

                $_SESSION["admin_id"] = $user["id"];

                $_SESSION["admin_name"] = $user["name"];

                $_SESSION["admin_email"] = $user["email"];

                $_SESSION["admin_role"] = $user["role"];


                header("Location: dashboard.php");

                exit;

            }

        }


        $error = "Invalid email or password.";

        mysqli_stmt_close($stmt);

    }

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
        Admin Login | Elegance Boutique
    </title>

    <link
        rel="stylesheet"
        href="admin.css"
    >

</head>


<body class="login-body">


<div class="login-container">


    <div class="login-card">


        <div class="login-logo">

            <a href="../index.php">

                ELEGANCE

                <span>
                    BOUTIQUE
                </span>

            </a>

        </div>


        <h1>
            Admin Login
        </h1>


        <p class="login-subtitle">

            Sign in to manage your boutique.

        </p>


        <?php if ($error !== ""): ?>

            <div class="alert error">

                <?= htmlspecialchars($error) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action=""
        >


            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="admin@example.com"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >

            </div>


            <button
                type="submit"
                class="admin-btn"
            >

                Login

            </button>


        </form>


        <a
            href="../index.php"
            class="back-home"
        >

            ← Back to Website

        </a>


    </div>


</div>


</body>

</html>