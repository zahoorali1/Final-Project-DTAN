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
| Get Existing Gallery Record
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare(
    $conn,

    "SELECT *
     FROM gallery
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


$gallery =
    mysqli_fetch_assoc($result);


mysqli_stmt_close($stmt);


if (!$gallery) {

    header("Location: gallery.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Get Products
|--------------------------------------------------------------------------
*/

$productQuery = mysqli_query(
    $conn,

    "SELECT id, name
     FROM products
     ORDER BY name ASC"
);


$error = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    /*
    |--------------------------------------------------------------------------
    | Product ID
    |--------------------------------------------------------------------------
    | Product is optional because gallery.product_id allows NULL.
    */

    $product_id = intval(
        $_POST["product_id"] ?? 0
    );


    if ($product_id <= 0) {

        $product_id = null;

    }


    $title = trim(
        $_POST["title"] ?? ""
    );


    $description = trim(
        $_POST["description"] ?? ""
    );


    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if ($title === "") {

        $error =
            "Image title is required.";

    }


    /*
    |--------------------------------------------------------------------------
    | Existing Image
    |--------------------------------------------------------------------------
    */

    $imagePath =
        $gallery["image"];


    /*
    |--------------------------------------------------------------------------
    | Replace Image
    |--------------------------------------------------------------------------
    */

    if (
        $error === "" &&
        isset($_FILES["image"]) &&
        $_FILES["image"]["error"] === UPLOAD_ERR_OK
    ) {


        $uploadDir =
            "../assets/images/gallery/";


        if (!is_dir($uploadDir)) {

            mkdir(
                $uploadDir,
                0777,
                true
            );

        }


        $originalName =
            $_FILES["image"]["name"];


        $tmpName =
            $_FILES["image"]["tmp_name"];


        $fileSize =
            $_FILES["image"]["size"];


        $extension = strtolower(
            pathinfo(
                $originalName,
                PATHINFO_EXTENSION
            )
        );


        $allowed = [

            "jpg",
            "jpeg",
            "png",
            "webp"

        ];


        if (
            !in_array(
                $extension,
                $allowed
            )
        ) {

            $error =
                "Only JPG, JPEG, PNG and WEBP images are allowed.";

        } elseif (
            $fileSize > 5 * 1024 * 1024
        ) {

            $error =
                "Image must be less than 5MB.";

        } else {


            $newName =
                uniqid(
                    "gallery_",
                    true
                )
                . "."
                . $extension;


            $destination =
                $uploadDir . $newName;


            if (
                move_uploaded_file(
                    $tmpName,
                    $destination
                )
            ) {


                /*
                |--------------------------------------------------------------------------
                | Delete Old Image
                |--------------------------------------------------------------------------
                */

                if (
                    !empty($gallery["image"]) &&
                    file_exists(
                        "../" . $gallery["image"]
                    )
                ) {

                    unlink(
                        "../" . $gallery["image"]
                    );

                }


                $imagePath =
                    "assets/images/gallery/"
                    . $newName;


            } else {

                $error =
                    "Failed to upload new image.";

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Update Database
    |--------------------------------------------------------------------------
    */

    if ($error === "") {


        /*
        |--------------------------------------------------------------------------
        | When product_id is NULL
        |--------------------------------------------------------------------------
        | MySQLi cannot bind NULL directly as an integer in the way
        | we want here, so we handle the query separately.
        */

        if ($product_id === null) {


            $stmt = mysqli_prepare(
                $conn,

                "UPDATE gallery

                 SET

                    product_id = NULL,
                    image = ?,
                    title = ?,
                    description = ?

                 WHERE id = ?"
            );


            mysqli_stmt_bind_param(
                $stmt,
                "sssi",

                $imagePath,
                $title,
                $description,
                $id
            );


        } else {


            $stmt = mysqli_prepare(
                $conn,

                "UPDATE gallery

                 SET

                    product_id = ?,
                    image = ?,
                    title = ?,
                    description = ?

                 WHERE id = ?"
            );


            mysqli_stmt_bind_param(
                $stmt,
                "isssi",

                $product_id,
                $imagePath,
                $title,
                $description,
                $id
            );

        }


        if (
            mysqli_stmt_execute($stmt)
        ) {


            mysqli_stmt_close($stmt);


            header(
                "Location: gallery.php"
            );

            exit;


        } else {


            $error =
                "Failed to update gallery: "
                . mysqli_error($conn);


            mysqli_stmt_close($stmt);

        }

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
        Edit Gallery | Admin
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



    <main class="admin-main">


        <header class="admin-header">


            <div>

                <p class="admin-eyebrow">

                    VISUAL CONTENT

                </p>


                <h1>

                    Edit Gallery Image

                </h1>

            </div>


        </header>



        <?php if ($error !== ""): ?>

            <div class="admin-alert error">

                <?= htmlspecialchars(
                    $error
                ) ?>

            </div>

        <?php endif; ?>



        <form
            method="POST"
            enctype="multipart/form-data"
            class="admin-form single-form"
        >


            <div class="form-section">


                <h2>
                    Gallery Information
                </h2>



                <!-- PRODUCT -->

                <div class="admin-form-group">


                    <label>

                        Product

                    </label>


                    <select
                        name="product_id"
                    >

                        <option value="">

                            No Product

                        </option>


                        <?php while (
                            $product =
                            mysqli_fetch_assoc(
                                $productQuery
                            )
                        ): ?>


                            <option
                                value="<?= $product["id"] ?>"
                                <?= (
                                    $gallery["product_id"]
                                    !== null &&
                                    $gallery["product_id"]
                                    == $product["id"]
                                )
                                    ? "selected"
                                    : ""
                                ?>
                            >

                                <?= htmlspecialchars(
                                    $product["name"]
                                ) ?>

                                (ID:
                                <?= $product["id"] ?>)

                            </option>


                        <?php endwhile; ?>


                    </select>


                    <small>

                        You can leave this empty if
                        the gallery image is not related
                        to a specific product.

                    </small>


                </div>



                <!-- TITLE -->

                <div class="admin-form-group">


                    <label>

                        Image Title *

                    </label>


                    <input
                        type="text"
                        name="title"
                        value="<?= htmlspecialchars(
                            $gallery["title"]
                        ) ?>"
                        required
                    >


                </div>



                <!-- DESCRIPTION -->

                <div class="admin-form-group">


                    <label>

                        Description

                    </label>


                    <textarea
                        name="description"
                        rows="5"
                    ><?= htmlspecialchars(
                        $gallery["description"]
                    ) ?></textarea>


                </div>



                <!-- CURRENT IMAGE -->

                <div class="admin-form-group">


                    <label>

                        Current Image

                    </label>


                    <?php if (
                        !empty(
                            $gallery["image"]
                        )
                    ): ?>


                        <img
                            src="../<?= htmlspecialchars(
                                $gallery["image"]
                            ) ?>"
                            class="edit-gallery-image"
                            alt=""
                        >


                    <?php else: ?>


                        <p>

                            No image available.

                        </p>


                    <?php endif; ?>


                </div>



                <!-- NEW IMAGE -->

                <div class="admin-form-group">


                    <label>

                        Replace Image

                    </label>


                    <input
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >


                    <small>

                        Leave empty to keep
                        the current image.

                    </small>


                </div>


            </div>



            <div class="form-actions">


                <a
                    href="gallery.php"
                    class="cancel-btn"
                >

                    Cancel

                </a>


                <button
                    type="submit"
                    class="admin-action-btn"
                >

                    Update Image

                </button>


            </div>


        </form>


    </main>


</div>


</body>

</html>