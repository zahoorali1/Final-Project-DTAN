<?php

session_start();

require_once "../config/database.php";


// Check login

if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");

    exit;

}


// Get admin information

$adminName = $_SESSION["admin_name"];

// ==========================================
// GET PENDING ORDERS COUNT
// ==========================================

$pendingOrders = 0;

$sql = "
    SELECT COUNT(*) AS total
    FROM orders
    WHERE status = 'Pending'
";

$result = mysqli_query($conn, $sql);

if ($result) {

    $row = mysqli_fetch_assoc($result);

    $pendingOrders = (int) $row["total"];

}

// Count products

$productQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM products"
);

$productData = mysqli_fetch_assoc(
    $productQuery
);

$totalProducts = $productData["total"];


// Count categories

$categoryQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM categories"
);

$categoryData = mysqli_fetch_assoc(
    $categoryQuery
);

$totalCategories = $categoryData["total"];


// Count gallery images

$galleryQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM gallery"
);

$galleryData = mysqli_fetch_assoc(
    $galleryQuery
);

$totalGallery = $galleryData["total"];


// Count team members

$teamQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM team"
);

$teamData = mysqli_fetch_assoc(
    $teamQuery
);

$totalTeam = $teamData["total"];


// Count messages

$messageQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM messages"
);

$messageData = mysqli_fetch_assoc(
    $messageQuery
);

$totalMessages = $messageData["total"];


// Count users

$userQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total
     FROM users"
);

$userData = mysqli_fetch_assoc(
    $userQuery
);

$totalUsers = $userData["total"];


// Featured products

$featuredQuery = mysqli_query(
    $conn,
    "SELECT
        p.id,
        p.name,
        p.price,
        p.image,
        c.name AS category_name
     FROM products p
     LEFT JOIN categories c
        ON p.category_id = c.id
     WHERE p.featured = 1
     ORDER BY p.id DESC
     LIMIT 5"
);

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
        Dashboard | Elegance Boutique
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

                <span>
                    BOUTIQUE
                </span>

            </a>

        </div>


        <nav class="sidebar-nav">


            <a
                href="dashboard.php"
                class="active"
            >

                <span>▣</span>

                Dashboard

            </a>


            <a href="products.php">

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


            <!-- TEAM -->

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


    <!-- MAIN CONTENT -->

    <main class="admin-main">


        <header class="admin-header">


            <div>

                <p class="admin-eyebrow">
                    ADMIN PANEL
                </p>

                <h1>
                    Dashboard
                </h1>

            </div>


            <div class="admin-user">

                Welcome,

                <strong>
                    <?= htmlspecialchars($adminName) ?>
                </strong>

            </div>


        </header>


        <!-- STATISTICS -->

        <section class="stats-grid">


            <div class="stat-card">

                <div class="stat-icon">
                    ◈
                </div>

                <div>

                    <span>
                        Products
                    </span>

                    <strong>
                        <?= $totalProducts ?>
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ◇
                </div>

                <div>

                    <span>
                        Categories
                    </span>

                    <strong>
                        <?= $totalCategories ?>
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ▧
                </div>

                <div>

                    <span>
                        Gallery
                    </span>

                    <strong>
                        <?= $totalGallery ?>
                    </strong>

                </div>

            </div>


            <!-- TEAM STATISTICS -->

            <div class="stat-card">

                <div class="stat-icon">
                    ♙
                </div>

                <div>

                    <span>
                        Team
                    </span>

                    <strong>
                        <?= $totalTeam ?>
                    </strong>

                </div>

            </div>


            <div class="stat-card">

                <div class="stat-icon">
                    ✉
                </div>

                <div>

                    <span>
                        Messages
                    </span>

                    <strong>
                        <?= $totalMessages ?>
                    </strong>

                </div>

            </div>

                <!-- ORDERS -->
    <div class="stat-card">

        <div class="stat-icon">
            🛍
        </div>

        <div>
            <span>
                Pending Orders
            </span>

            <strong>
                <?= $pendingOrders ?>
            </strong>
        </div>
    </div>
</section>


        <!-- QUICK ACTIONS -->

        <section class="dashboard-section">


            <div class="section-title">

                <div>

                    <p class="admin-eyebrow">
                        MANAGEMENT
                    </p>

                    <h2>
                        Quick Actions
                    </h2>

                </div>

            </div>


            <div class="quick-actions">


                <a
                    href="product_add.php"
                    class="quick-card"
                >

                    <strong>
                        + Add Product
                    </strong>

                    <span>
                        Add a new clothing item
                    </span>

                </a>


                <a
                    href="categories.php"
                    class="quick-card"
                >

                    <strong>
                        + Add Category
                    </strong>

                    <span>
                        Manage product categories
                    </span>

                </a>


                <a
                    href="gallery_add.php"
                    class="quick-card"
                >

                    <strong>
                        + Add Gallery Image
                    </strong>

                    <span>
                        Upload boutique photos
                    </span>

                </a>


                <!-- TEAM QUICK ACTION -->

                <a
                    href="team_add.php"
                    class="quick-card"
                >

                    <strong>
                        + Add Team Member
                    </strong>

                    <span>
                        Add boutique team member
                    </span>

                </a>


                <a
                    href="messages.php"
                    class="quick-card"
                >

                    <strong>
                        View Messages
                    </strong>

                    <span>
                        Read customer enquiries
                    </span>

                </a>

                <a
    href="orders.php"
    class="quick-card"
>

    <strong>
        View Orders
    </strong>

    <span>
        Manage customer orders
    </span>

</a>


            </div>


        </section>


        <!-- FEATURED PRODUCTS -->

        <section class="dashboard-section">


            <div class="section-title">


                <div>

                    <p class="admin-eyebrow">
                        PRODUCTS
                    </p>

                    <h2>
                        Featured Products
                    </h2>

                </div>


                <a
                    href="products.php"
                    class="view-all"
                >

                    View All →

                </a>


            </div>


            <div class="admin-table-wrapper">


                <table class="admin-table">


                    <thead>

                        <tr>

                            <th>
                                Product
                            </th>

                            <th>
                                Category
                            </th>

                            <th>
                                Price
                            </th>

                        </tr>

                    </thead>


                    <tbody>


                    <?php if (
                        mysqli_num_rows($featuredQuery) > 0
                    ): ?>


                        <?php while (
                            $product =
                            mysqli_fetch_assoc(
                                $featuredQuery
                            )
                        ): ?>


                            <tr>


                                <td>

                                    <div class="table-product">


                                        <?php if (
                                            !empty(
                                                $product["image"]
                                            )
                                        ): ?>

                                            <img
                                                src="../<?= htmlspecialchars($product["image"]) ?>"
                                                alt="<?= htmlspecialchars($product["name"]) ?>"
                                            >

                                        <?php endif; ?>


                                        <span>

                                            <?= htmlspecialchars(
                                                $product["name"]
                                            ) ?>

                                        </span>


                                    </div>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $product["category_name"]
                                    ) ?>

                                </td>


                                <td>

                                    Rs.

                                    <?= number_format(
                                        $product["price"]
                                    ) ?>

                                </td>


                            </tr>


                        <?php endwhile; ?>


                    <?php else: ?>


                        <tr>

                            <td colspan="3">

                                No featured products found.

                            </td>

                        </tr>


                    <?php endif; ?>


                    </tbody>


                </table>


            </div>


        </section>


    </main>


</div>


</body>

</html>