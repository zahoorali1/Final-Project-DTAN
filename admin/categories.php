<?php

session_start();

require_once "../config/database.php";


if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");
    exit;

}


$result = mysqli_query(
    $conn,

    "SELECT
        c.id,
        c.name,
        c.description,
        c.created_at,
        COUNT(p.id) AS product_count

     FROM categories c

     LEFT JOIN products p
        ON c.id = p.category_id

     GROUP BY c.id

     ORDER BY c.id DESC"
);


if (!$result) {

    die(
        "Category query failed: "
        . mysqli_error($conn)
    );

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
        Categories | Admin
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
                    Categories
                </h1>

            </div>


            <a
                href="category_add.php"
                class="admin-action-btn"
            >
                + Add Category
            </a>

        </header>



        <div class="admin-table-wrapper">

            <table class="admin-table">


                <thead>

                    <tr>

                        <th>
                            Name
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            Products
                        </th>

                        <th>
                            Created
                        </th>

                        <th>
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>


                <?php if (
                    mysqli_num_rows($result) > 0
                ): ?>


                    <?php while (
                        $category =
                        mysqli_fetch_assoc($result)
                    ): ?>


                        <tr>


                            <td>

                                <strong>

                                    <?= htmlspecialchars(
                                        $category["name"]
                                    ) ?>

                                </strong>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $category["description"]
                                    ?? ""
                                ) ?>

                            </td>


                            <td>

                                <span class="count-badge">

                                    <?= $category["product_count"] ?>

                                </span>

                            </td>


                            <td>

                                <?= date(
                                    "d M Y",
                                    strtotime(
                                        $category["created_at"]
                                    )
                                ) ?>

                            </td>


                            <td>

                                <div class="table-actions">


                                    <a
                                        href="category_edit.php?id=<?= $category["id"] ?>"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>


                                    <a
                                        href="category_delete.php?id=<?= $category["id"] ?>"
                                        class="delete-btn"
                                        onclick="return confirm('Delete this category? Products using this category may prevent deletion.');"
                                    >
                                        Delete
                                    </a>


                                </div>

                            </td>


                        </tr>


                    <?php endwhile; ?>


                <?php else: ?>


                    <tr>

                        <td
                            colspan="5"
                            class="empty-row"
                        >

                            No categories found.

                        </td>

                    </tr>


                <?php endif; ?>


                </tbody>


            </table>

        </div>


    </main>


</div>


</body>

</html>