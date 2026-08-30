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


// Get category

$stmt = mysqli_prepare(
    $conn,

    "SELECT *
     FROM categories
     WHERE id = ?
     LIMIT 1"
);


mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result =
    mysqli_stmt_get_result($stmt);

$category =
    mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$category) {

    header("Location: categories.php");
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


        // Check duplicate category

        $check = mysqli_prepare(
            $conn,

            "SELECT id
             FROM categories
             WHERE name = ?
             AND id != ?
             LIMIT 1"
        );


        mysqli_stmt_bind_param(
            $check,
            "si",
            $name,
            $id
        );


        mysqli_stmt_execute($check);

        $checkResult =
            mysqli_stmt_get_result(
                $check
            );


        if (
            mysqli_num_rows(
                $checkResult
            ) > 0
        ) {

            $error =
                "Another category already uses this name.";

        } else {


            $stmt = mysqli_prepare(
                $conn,

                "UPDATE categories

                 SET
                    name = ?,
                    description = ?

                 WHERE id = ?"
            );


            mysqli_stmt_bind_param(
                $stmt,
                "ssi",
                $name,
                $description,
                $id
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
                    "Failed to update category: "
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
        Edit Category | Admin
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
                    Edit Category
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
                        value="<?= htmlspecialchars(
                            $category["name"]
                        ) ?>"
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
                    ><?= htmlspecialchars(
                        $category["description"]
                    ) ?></textarea>

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
                    Update Category
                </button>

            </div>


        </form>


    </main>


</div>


</body>

</html>