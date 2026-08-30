<?php

session_start();

require_once "../config/database.php";


if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Get Gallery Images
|--------------------------------------------------------------------------
| gallery.product_id connects to products.id
*/

$query = "

    SELECT

        g.id,
        g.product_id,
        g.image,
        g.title,
        g.description,
        g.created_at,

        p.name AS product_name

    FROM gallery g

    LEFT JOIN products p
        ON g.product_id = p.id

    ORDER BY g.id DESC

";


$result = mysqli_query($conn, $query);


if (!$result) {

    die(
        "Gallery query failed: "
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
        Gallery | Admin
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


            <a href="products.php">

                <span>◈</span>

                Products

            </a>


            <a href="categories.php">

                <span>◇</span>

                Categories

            </a>


            <a
                href="gallery.php"
                class="active"
            >

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



    <!-- MAIN CONTENT -->

    <main class="admin-main">


        <header class="admin-header">


            <div>

                <p class="admin-eyebrow">

                    VISUAL CONTENT

                </p>


                <h1>

                    Gallery

                </h1>

            </div>


            <a
                href="gallery_add.php"
                class="admin-action-btn"
            >

                + Add Image

            </a>


        </header>



        <!-- GALLERY GRID -->

        <div class="gallery-admin-grid">


            <?php if (
                mysqli_num_rows($result) > 0
            ): ?>


                <?php while (
                    $gallery =
                    mysqli_fetch_assoc($result)
                ): ?>


                    <div class="gallery-admin-card">


                        <!-- IMAGE -->

                        <div class="gallery-admin-image">


                            <?php if (
                                !empty(
                                    $gallery["image"]
                                )
                            ): ?>


                                <img
                                    src="../<?= htmlspecialchars(
                                        $gallery["image"]
                                    ) ?>"
                                    alt="<?= htmlspecialchars(
                                        $gallery["title"]
                                    ) ?>"
                                >


                            <?php else: ?>


                                <div class="gallery-no-image">

                                    No Image

                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- DETAILS -->

                        <div class="gallery-admin-content">


                            <h3>

                                <?= htmlspecialchars(
                                    $gallery["title"]
                                ) ?>

                            </h3>


                            <p>

                                <?php if (
                                    !empty(
                                        $gallery["product_name"]
                                    )
                                ): ?>

                                    Product:

                                    <strong>

                                        <?= htmlspecialchars(
                                            $gallery["product_name"]
                                        ) ?>

                                    </strong>

                                <?php else: ?>

                                    Product not assigned

                                <?php endif; ?>

                            </p>


                            <?php if (
                                !empty(
                                    $gallery["description"]
                                )
                            ): ?>

                                <p class="gallery-description">

                                    <?= htmlspecialchars(
                                        $gallery["description"]
                                    ) ?>

                                </p>

                            <?php endif; ?>



                            <div class="gallery-card-actions">


                                <a
                                    href="gallery_edit.php?id=<?= $gallery["id"] ?>"
                                    class="edit-btn"
                                >

                                    Edit

                                </a>


                                <a
                                    href="gallery_delete.php?id=<?= $gallery["id"] ?>"
                                    class="delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this gallery image?');"
                                >

                                    Delete

                                </a>


                            </div>


                        </div>


                    </div>


                <?php endwhile; ?>


            <?php else: ?>


                <div class="gallery-empty">

                    <h2>
                        No gallery images
                    </h2>

                    <p>
                        Add your first boutique image.
                    </p>

                    <a
                        href="gallery_add.php"
                        class="admin-action-btn"
                    >
                        + Add Image
                    </a>

                </div>


            <?php endif; ?>


        </div>


    </main>


</div>


</body>

</html>