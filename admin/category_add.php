<?php

session_start();

require_once "../config/database.php";


if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");
    exit;

}


$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $name = trim(
        $_POST["name"] ?? ""
    );

    $description = trim(
        $_POST["description"] ?? ""
    );


    if ($name === "") {

        $error =
            "Category name is required.";

    } else {


        // Check duplicate

        $check = mysqli_prepare(
            $conn,

            "SELECT id
             FROM categories
             WHERE name = ?
             LIMIT 1"
        );


        mysqli_stmt_bind_param(
            $check,
            "s",
            $name
        );

        mysqli_stmt_execute($check);

        $checkResult =
            mysqli_stmt_get_result($check);


        if (
            mysqli_num_rows(
                $checkResult
            ) > 0
        ) {

            $error =
                "This category already exists.";

        } else {


            $stmt = mysqli_prepare(
                $conn,

                "INSERT INTO categories
                (name, description)
                VALUES (?, ?)"
            );


            mysqli_stmt_bind_param(
                $stmt,
                "ss",
                $name,
                $description
            );


            if (
                mysqli_stmt_execute($stmt)
            ) {

                header(
                    "Location: categories.php"
                );

                exit;

            } else {

                $error =
                    "Failed to add category: "
                    . mysqli_error($conn);

            }


            mysqli_stmt_close($stmt);

        }


        mysqli_stmt_close($check);

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
        Add Category | Admin
    </title>

    <link
        rel="stylesheet"
        href="admin.css"
    >

</head>


<body>


<div class="admin-layout">


    <aside class="sidebar">

        <div class="admin-logo">

            <a href="../index.php">

                ELEGANCE

                <span>BOUTIQUE</span>

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

            <a
                href="categories.php"
                class="active"
            >
                <span>◇</span>
                Categories
            </a>

            <a href="gallery.php">
                <span>▧</span>
                Gallery
            </a>

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

            <a href="../index.php">
                View Website
            </a>

            <a href="logout.php">
                Logout
            </a>

        </div>

    </aside>



    <main class="admin-main">


        <header class="admin-header">

            <div>

                <p class="admin-eyebrow">
                    PRODUCT ORGANIZATION
                </p>

                <h1>
                    Add Category
                </h1>

            </div>

        </header>


        <?php if ($error !== ""): ?>

            <div class="admin-alert error">

                <?= htmlspecialchars($error) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            class="admin-form single-form"
        >


            <div class="form-section">


                <h2>
                    Category Information
                </h2>


                <div class="admin-form-group">

                    <label>
                        Category Name *
                    </label>

                    <input
                        type="text"
                        name="name"
                        placeholder="e.g. Dresses"
                        required
                    >

                </div>


                <div class="admin-form-group">

                    <label>
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="6"
                        placeholder="Describe this category..."
                    ></textarea>

                </div>


            </div>


            <div class="form-actions">

                <a
                    href="categories.php"
                    class="cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="admin-action-btn"
                >
                    Add Category
                </button>

            </div>


        </form>


    </main>


</div>


</body>

</html>