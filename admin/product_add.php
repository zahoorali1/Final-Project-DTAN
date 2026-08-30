<?php

session_start();

require_once "../config/database.php";


if (!isset($_SESSION["admin_id"])) {

    header("Location: login.php");
    exit;

}


$error = "";
$success = "";


// Get categories

$categoryQuery = mysqli_query(
    $conn,
    "SELECT id, name
     FROM categories
     ORDER BY name ASC"
);


if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $name = trim(
        $_POST["name"] ?? ""
    );

    $category_id = intval(
        $_POST["category_id"] ?? 0
    );

    $description = trim(
        $_POST["description"] ?? ""
    );

    $price = floatval(
        $_POST["price"] ?? 0
    );

    $sizes = trim(
        $_POST["sizes"] ?? ""
    );

    $status = $_POST["status"] ?? "active";

    $featured = isset(
        $_POST["featured"]
    ) ? 1 : 0;


    // Validate

    if (
        $name === "" ||
        $category_id <= 0 ||
        $price <= 0
    ) {

        $error =
            "Please fill in all required fields.";

    } else {


        // Image

        $imagePath = "";


        if (
            isset($_FILES["image"]) &&
            $_FILES["image"]["error"] === UPLOAD_ERR_OK
        ) {


            $uploadDir =
                "../assets/images/products/";


            if (!is_dir($uploadDir)) {

                mkdir(
                    $uploadDir,
                    0777,
                    true
                );

            }


            $fileName =
                $_FILES["image"]["name"];


            $tmpName =
                $_FILES["image"]["tmp_name"];


            $fileSize =
                $_FILES["image"]["size"];


            $extension = strtolower(
                pathinfo(
                    $fileName,
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
                        "product_",
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

                    $imagePath =
                        "assets/images/products/"
                        . $newName;

                } else {

                    $error =
                        "Failed to upload image.";

                }

            }

        }


        if ($error === "") {


            $stmt = mysqli_prepare(
                $conn,

                "INSERT INTO products
                (
                    category_id,
                    name,
                    description,
                    price,
                    sizes,
                    image,
                    status,
                    featured
                )

                VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
            );


            mysqli_stmt_bind_param(
                $stmt,
                "issdsssi",

                $category_id,
                $name,
                $description,
                $price,
                $sizes,
                $imagePath,
                $status,
                $featured
            );


            if (
                mysqli_stmt_execute($stmt)
            ) {

                $success =
                    "Product added successfully.";

                $_POST = [];

            } else {

                $error =
                    "Failed to add product: "
                    . mysqli_error($conn);

            }


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
        Add Product | Admin
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
                    INVENTORY
                </p>

                <h1>
                    Add Product
                </h1>

            </div>

        </header>


        <?php if ($error !== ""): ?>

            <div class="admin-alert error">

                <?= htmlspecialchars($error) ?>

            </div>

        <?php endif; ?>


        <?php if ($success !== ""): ?>

            <div class="admin-alert success">

                <?= htmlspecialchars($success) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            enctype="multipart/form-data"
            class="admin-form"
        >


            <div class="form-grid">


                <div class="form-section">


                    <h2>
                        Product Information
                    </h2>


                    <div class="admin-form-group">

                        <label>
                            Product Name *
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="<?= htmlspecialchars(
                                $_POST["name"] ?? ""
                            ) ?>"
                            required
                        >

                    </div>


                    <div class="admin-form-group">

                        <label>
                            Category *
                        </label>

                        <select
                            name="category_id"
                            required
                        >

                            <option value="">
                                Select Category
                            </option>


                            <?php while (
                                $category =
                                mysqli_fetch_assoc(
                                    $categoryQuery
                                )
                            ): ?>

                                <option
                                    value="<?= $category["id"] ?>"
                                    <?= (
                                        ($_POST["category_id"] ?? "")
                                        == $category["id"]
                                    )
                                        ? "selected"
                                        : ""
                                    ?>
                                >

                                    <?= htmlspecialchars(
                                        $category["name"]
                                    ) ?>

                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>


                    <div class="admin-form-group">

                        <label>
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="6"
                        ><?= htmlspecialchars(
                            $_POST["description"] ?? ""
                        ) ?></textarea>

                    </div>


                    <div class="form-row">


                        <div class="admin-form-group">

                            <label>
                                Price *
                            </label>

                            <input
                                type="number"
                                name="price"
                                step="0.01"
                                min="0"
                                value="<?= htmlspecialchars(
                                    $_POST["price"] ?? ""
                                ) ?>"
                                required
                            >

                        </div>


                        <div class="admin-form-group">

                            <label>
                                Sizes
                            </label>

                            <input
                                type="text"
                                name="sizes"
                                placeholder="S, M, L, XL"
                                value="<?= htmlspecialchars(
                                    $_POST["sizes"] ?? ""
                                ) ?>"
                            >

                        </div>


                    </div>


                </div>



                <div class="form-section">


                    <h2>
                        Product Settings
                    </h2>


                    <div class="admin-form-group">

                        <label>
                            Status
                        </label>

                        <select name="status">

                            <option
                                value="Available"
                            >
                                Available
                            </option>

                            <option
                                value="Out of Stock"
                            >
                                Out of Stock
                            </option>

                        </select>

                    </div>


                    <div class="checkbox-group">

                        <label>

                            <input
                                type="checkbox"
                                name="featured"
                                value="1"
                            >

                            Featured Product

                        </label>

                    </div>


                    <div class="admin-form-group">

                        <label>
                            Product Image
                        </label>

                        <input
                            type="file"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <small>
                            Maximum 5MB.
                        </small>

                    </div>


                </div>


            </div>


            <div class="form-actions">

                <a
                    href="products.php"
                    class="cancel-btn"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="admin-action-btn"
                >
                    Add Product
                </button>

            </div>


        </form>


    </main>


</div>


</body>

</html>