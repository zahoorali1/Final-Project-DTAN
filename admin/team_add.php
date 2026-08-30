<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");

    $position = trim($_POST["position"] ?? "");

    $bio = trim($_POST["bio"] ?? "");

    if ($name === "" || $position === "") {

        $error = "Name and position are required.";

    } else {

        $imageName = "";

        if (
            isset($_FILES["image"]) &&
            $_FILES["image"]["error"] === UPLOAD_ERR_OK
        ) {

            $allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            $fileType = mime_content_type($_FILES["image"]["tmp_name"]);

            if (!in_array($fileType, $allowedTypes)) {

                $error = "Only JPG, PNG and WEBP images are allowed.";

            } elseif ($_FILES["image"]["size"] > 5 * 1024 * 1024) {

                $error = "Image must be less than 5MB.";

            } else {

                $extension = strtolower(
                    pathinfo(
                        $_FILES["image"]["name"],
                        PATHINFO_EXTENSION
                    )
                );

$imageName = basename($_FILES["image"]["name"]);

$uploadPath = "../../uploads/team/" . $imageName;

if (!move_uploaded_file(
    $_FILES["image"]["tmp_name"],
    $uploadPath
)) {

    $error = "Failed to upload image.";

    $imageName = "";
}

        if ($error === "") {

            $stmt = mysqli_prepare(
                $conn,
                "
                INSERT INTO team
                (name, position, bio, image)
                VALUES (?, ?, ?, ?)
                "
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $name,
                $position,
                $bio,
                $imageName
            );

            if (mysqli_stmt_execute($stmt)) {

                header("Location: index.php");

                exit;

            } else {

                $error = "Failed to add team member.";
            }

            mysqli_stmt_close($stmt);
        }
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

    <title>Add Team Member</title>

    <link rel="stylesheet" href="admin.css">

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


<div class="admin-container">

    <h1>Add Team Member</h1>

    <?php if ($error !== ""): ?>

        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <form
        method="POST"
        enctype="multipart/form-data" class="team-form"
    >

        <label>
            Name
        </label>

        <input
            type="text"
            name="name"
            required
        >

        <br><br>

        <label>
            Position
        </label>

        <input
            type="text"
            name="position"
            required
        >

        <br><br>

        <label>
            Biography
        </label>

        <textarea
            name="bio"
            rows="6"
        ></textarea>

        <br><br>

        <label>
            Team Image
        </label>

        <input
            type="file"
            name="image"
            accept="image/jpeg,image/png,image/webp"
        >

        <br><br>

        <button type="submit">
            Add Team Member
        </button>

        <a href="team.php">
            Cancel
        </a>

    </form>

</div>

</body>

</html>