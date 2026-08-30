<?php

session_start();

require_once "../config/database.php";


if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");
    exit;

}


// Get products with category names

$query = "
    SELECT
        p.id,
        p.name,
        p.description,
        p.price,
        p.sizes,
        p.image,
        p.status,
        p.featured,
        p.created_at,
        c.name AS category_name

    FROM products p

    LEFT JOIN categories c
        ON p.category_id = c.id

    ORDER BY p.id DESC
";


$result = mysqli_query($conn, $query);


if (!$result) {

    die(
        "Product query failed: "
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
        Products | Admin
    </title>

    <link
        rel="stylesheet"
        href="admin.css"
    >

</head>


<body>


<div class="admin-layout">


    <!-- SIDEBAR -->

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

            <a
                href="products.php"
                class="active"
            >
                <span>◈</span>
                Products
            </a>

            <a href="categories.php">
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

            <a
                href="../index.php"
                target="_blank"
            >
                View Website
            </a>

            <a href="logout.php">
                Logout
            </a>

        </div>

    </aside>



    <!-- MAIN -->

    <main class="admin-main">


        <header class="admin-header">

            <div>

                <p class="admin-eyebrow">
                    INVENTORY
                </p>

                <h1>
                    Products
                </h1>

            </div>


            <a
                href="product_add.php"
                class="admin-action-btn"
            >
                + Add Product
            </a>

        </header>



        <!-- PRODUCT TABLE -->

        <div class="admin-table-wrapper">

            <table class="admin-table">


                <thead>

                    <tr>

                        <th>
                            Image
                        </th>

                        <th>
                            Product
                        </th>

                        <th>
                            Category
                        </th>

                        <th>
                            Price
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Featured
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
                        $product =
                        mysqli_fetch_assoc($result)
                    ): ?>


                        <tr>


                            <!-- IMAGE -->

                            <td>

                                <?php if (
                                    !empty($product["image"])
                                ): ?>

                                    <img
                                        src="../<?= htmlspecialchars($product["image"]) ?>"
                                        alt="<?= htmlspecialchars($product["name"]) ?>"
                                        class="admin-product-image"
                                    >

                                <?php else: ?>

                                    <div class="no-image">
                                        No Image
                                    </div>

                                <?php endif; ?>

                            </td>


                            <!-- NAME -->

                            <td>

                                <strong>

                                    <?= htmlspecialchars(
                                        $product["name"]
                                    ) ?>

                                </strong>

                                <?php if (
                                    !empty(
                                        $product["sizes"]
                                    )
                                ): ?>

                                    <small>

                                        Sizes:
                                        <?= htmlspecialchars(
                                            $product["sizes"]
                                        ) ?>

                                    </small>

                                <?php endif; ?>

                            </td>


                            <!-- CATEGORY -->

                            <td>

                                <?= htmlspecialchars(
                                    $product["category_name"]
                                    ?? "Uncategorized"
                                ) ?>

                            </td>


                            <!-- PRICE -->

                            <td>

                                Rs.
                                <?= number_format(
                                    $product["price"]
                                ) ?>

                            </td>


                            <!-- STATUS -->

                            <td>

                                <?php if (
                                    $product["status"] === "Available"
                                ): ?>

                                    <span class="status active-status">
                                        Available
                                    </span>

                                <?php else: ?>

                                    <span class="status inactive-status">
                                        Out of Stock
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- FEATURED -->

                            <td>

                                <?php if (
                                    $product["featured"] == 1
                                ): ?>

                                    <span class="featured">
                                        Yes
                                    </span>

                                <?php else: ?>

                                    <span class="not-featured">
                                        No
                                    </span>

                                <?php endif; ?>

                            </td>


                            <!-- ACTIONS -->

                            <td>

                                <div class="table-actions">


                                    <a
                                        href="product_edit.php?id=<?= $product["id"] ?>"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>


                                    <a
                                        href="product_delete.php?id=<?= $product["id"] ?>"
                                        class="delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this product?');"
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
                            colspan="7"
                            class="empty-row"
                        >

                            No products found.

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