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


$error = "";
$success = "";


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


if (!$productQuery) {

    die(
        "Product query failed: "
        . mysqli_error($conn)
    );

}


/*
|--------------------------------------------------------------------------
| Handle Form Submission
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    /*
    |--------------------------------------------------------------------------
    | Product ID
    |--------------------------------------------------------------------------
    |
    | 0 means no product.
    | Later we convert 0 to NULL in MySQL.
    |
    */

    $product_id = intval(
        $_POST["product_id"] ?? 0
    );


    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    */

    $title = trim(
        $_POST["title"] ?? ""
    );


    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    */

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
            "Please enter an image title.";

    } elseif (
        !isset($_FILES["image"]) ||
        $_FILES["image"]["error"] !== UPLOAD_ERR_OK
    ) {

        $error =
            "Please select an image.";

    }


    /*
    |--------------------------------------------------------------------------
    | Upload Image
    |--------------------------------------------------------------------------
    */

    if ($error === "") {


        $uploadDir =
            "../assets/images/gallery/";


        /*
        |--------------------------------------------------------------------------
        | Create Folder If It Doesn't Exist
        |--------------------------------------------------------------------------
        */

        if (!is_dir($uploadDir)) {

            mkdir(
                $uploadDir,
                0777,
                true
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Uploaded File Information
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Allowed Image Types
        |--------------------------------------------------------------------------
        */

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

        }


        /*
        |--------------------------------------------------------------------------
        | Maximum File Size
        |--------------------------------------------------------------------------
        */

        if (
            $fileSize > 5 * 1024 * 1024
        ) {

            $error =
                "Image must be less than 5MB.";

        }


        /*
        |--------------------------------------------------------------------------
        | Continue If No Error
        |--------------------------------------------------------------------------
        */

        if ($error === "") {


            /*
            |--------------------------------------------------------------------------
            | Create Unique File Name
            |--------------------------------------------------------------------------
            */

            $newName =
                uniqid(
                    "gallery_",
                    true
                )
                . "."
                . $extension;


            $destination =
                $uploadDir . $newName;


            /*
            |--------------------------------------------------------------------------
            | Move Uploaded Image
            |--------------------------------------------------------------------------
            */

            if (
                move_uploaded_file(
                    $tmpName,
                    $destination
                )
            ) {


                /*
                |--------------------------------------------------------------------------
                | Database Image Path
                |--------------------------------------------------------------------------
                */

                $imagePath =
                    "assets/images/gallery/"
                    . $newName;


                /*
                |--------------------------------------------------------------------------
                | Insert Gallery Record
                |--------------------------------------------------------------------------
                |
                | NULLIF(?, 0) converts:
                |
                | 0 -> NULL
                | 1 -> 1
                | 2 -> 2
                | 3 -> 3
                |
                */

                $stmt = mysqli_prepare(
                    $conn,

                    "INSERT INTO gallery
                    (
                        product_id,
                        image,
                        title,
                        description
                    )

                    VALUES
                    (
                        NULLIF(?, 0),
                        ?,
                        ?,
                        ?
                    )"
                );


                if (!$stmt) {

                    $error =
                        "Database preparation failed: "
                        . mysqli_error($conn);

                } else {


                    mysqli_stmt_bind_param(
                        $stmt,
                        "isss",

                        $product_id,
                        $imagePath,
                        $title,
                        $description
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Execute
                    |--------------------------------------------------------------------------
                    */

                    if (
                        mysqli_stmt_execute($stmt)
                    ) {


                        $success =
                            "Gallery image added successfully.";


                        /*
                        |--------------------------------------------------------------------------
                        | Clear Form
                        |--------------------------------------------------------------------------
                        */

                        $_POST = [];


                    } else {


                        /*
                        |--------------------------------------------------------------------------
                        | Delete Uploaded Image If DB Insert Fails
                        |--------------------------------------------------------------------------
                        */

                        if (
                            file_exists(
                                $destination
                            )
                        ) {

                            unlink(
                                $destination
                            );

                        }


                        $error =
                            "Database error: "
                            . mysqli_error($conn);

                    }


                    mysqli_stmt_close($stmt);

                }


            } else {

                $error =
                    "Failed to upload image.";

            }

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
        Add Gallery Image | Admin
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

                    Add Gallery Image

                </h1>

            </div>


        </header>



        <!-- ERROR -->

        <?php if ($error !== ""): ?>

            <div class="admin-alert error">

                <?= htmlspecialchars(
                    $error
                ) ?>

            </div>

        <?php endif; ?>



        <!-- SUCCESS -->

        <?php if ($success !== ""): ?>

            <div class="admin-alert success">

                <?= htmlspecialchars(
                    $success
                ) ?>

            </div>

        <?php endif; ?>



        <!-- FORM -->

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


                        <!-- GENERAL IMAGE -->

                        <option
                            value="0"
                            <?= (
                                ($_POST["product_id"] ?? "0")
                                == "0"
                            )
                                ? "selected"
                                : ""
                            ?>
                        >

                            No Product /
                            General Gallery Image

                        </option>



                        <!-- PRODUCTS -->

                        <?php while (
                            $product =
                            mysqli_fetch_assoc(
                                $productQuery
                            )
                        ): ?>


                            <option
                                value="<?= $product["id"] ?>"

                                <?= (
                                    ($_POST["product_id"] ?? "")
                                    ==
                                    $product["id"]
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

                        Select a product if this image
                        belongs to a specific product.
                        Otherwise choose "No Product".

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
                        placeholder="Example: Black Evening Dress"
                        value="<?= htmlspecialchars(
                            $_POST["title"] ?? ""
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
                        placeholder="Describe this image..."
                    ><?= htmlspecialchars(
                        $_POST["description"] ?? ""
                    ) ?></textarea>


                </div>



                <!-- IMAGE -->

                <div class="admin-form-group">


                    <label>

                        Image *

                    </label>


                    <input
                        type="file"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                        required
                    >


                    <small>

                        JPG, JPEG, PNG or WEBP.
                        Maximum 5MB.

                    </small>


                </div>


            </div>



            <!-- BUTTONS -->

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

                    Add Image

                </button>


            </div>


        </form>


    </main>


</div>


</body>

</html>