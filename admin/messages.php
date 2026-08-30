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
| Get Contact Messages
|--------------------------------------------------------------------------
*/

$query = "

    SELECT
        id,
        name,
        email,
        phone,
        message,
        created_at

    FROM messages

    ORDER BY id DESC

";


$result = mysqli_query(
    $conn,
    $query
);


if (!$result) {

    die(
        "Messages query failed: "
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
        Messages | Admin
    </title>


    <link
        rel="stylesheet"
        href="admin.css"
    >

</head>


<body>


<div class="admin-layout">


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

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


            <a href="gallery.php">

                <span>▧</span>

                Gallery

            </a>

            <a href="team.php">

                <span>♙</span>

                Team

            </a>

            <a
                href="messages.php"
                class="active"
            >

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



    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main class="admin-main">


        <header class="admin-header">


            <div>

                <p class="admin-eyebrow">

                    CUSTOMER CONTACT

                </p>


                <h1>

                    Messages

                </h1>

            </div>


        </header>



        <!-- =================================================
             MESSAGES
        ================================================== -->

        <div class="messages-container">


            <?php if (
                mysqli_num_rows($result) > 0
            ): ?>


                <?php while (
                    $message =
                    mysqli_fetch_assoc($result)
                ): ?>


                    <div class="message-card">


                        <!-- =================================================
                             MESSAGE HEADER
                        ================================================== -->

                        <div class="message-header">


                            <div>


                                <h2>

                                    <?= htmlspecialchars(
                                        $message["name"]
                                    ) ?>

                                </h2>


                                <p class="message-date">

                                    <?= htmlspecialchars(
                                        date(
                                            "d M Y, h:i A",
                                            strtotime(
                                                $message["created_at"]
                                            )
                                        )
                                    ) ?>

                                </p>


                            </div>


                            <a
                                href="message_delete.php?id=<?= $message["id"] ?>"
                                class="delete-btn"

                                onclick="return confirm('Are you sure you want to delete this message?');"
                            >

                                Delete

                            </a>


                        </div>



                        <!-- =================================================
                             CONTACT INFORMATION
                        ================================================== -->

                        <div class="message-contact">


                            <div>


                                <strong>

                                    Email

                                </strong>


                                <a
                                    href="mailto:<?= htmlspecialchars(
                                        $message["email"]
                                    ) ?>"
                                >

                                    <?= htmlspecialchars(
                                        $message["email"]
                                    ) ?>

                                </a>


                            </div>



                            <?php if (
                                !empty(
                                    $message["phone"]
                                )
                            ): ?>


                                <div>


                                    <strong>

                                        Phone

                                    </strong>


                                    <a
                                        href="tel:<?= htmlspecialchars(
                                            $message["phone"]
                                        ) ?>"
                                    >

                                        <?= htmlspecialchars(
                                            $message["phone"]
                                        ) ?>

                                    </a>


                                </div>


                            <?php endif; ?>


                        </div>



                        <!-- =================================================
                             MESSAGE
                        ================================================== -->

                        <div class="message-body">


                            <strong>

                                Message

                            </strong>


                            <p>

                                <?= nl2br(
                                    htmlspecialchars(
                                        $message["message"]
                                    )
                                ) ?>

                            </p>


                        </div>


                    </div>


                <?php endwhile; ?>


            <?php else: ?>


                <!-- =================================================
                     NO MESSAGES
                ================================================== -->

                <div class="messages-empty">


                    <div class="empty-icon">

                        ✉

                    </div>


                    <h2>

                        No Messages Yet

                    </h2>


                    <p>

                        Contact form submissions
                        will appear here.

                    </p>


                </div>


            <?php endif; ?>


        </div>


    </main>


</div>


</body>

</html>