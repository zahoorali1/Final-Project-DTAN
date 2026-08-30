```php
<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);

if ($id <= 0) {
    header("Location: team.php");
    exit;
}


/* =========================================================
   GET TEAM MEMBER
========================================================= */

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM team WHERE id = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$member = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if (!$member) {
    header("Location: team.php");
    exit;
}


$error = "";


/* =========================================================
   UPDATE TEAM MEMBER
========================================================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");

    $position = trim($_POST["position"] ?? "");

    $bio = trim($_POST["bio"] ?? "");


    /* -----------------------------------------------------
       VALIDATION
    ----------------------------------------------------- */

    if ($name === "" || $position === "") {

        $error = "Name and position are required.";

    } else {

        /*
         * Keep existing image if no new image is uploaded.
         */
        $imageName = $member["image"];


        /* -------------------------------------------------
           IMAGE UPLOAD
        ------------------------------------------------- */

        if (
            isset($_FILES["image"]) &&
            $_FILES["image"]["error"] === UPLOAD_ERR_OK
        ) {

            $allowedTypes = [
                "image/jpeg",
                "image/png",
                "image/webp"
            ];

            $fileType = mime_content_type(
                $_FILES["image"]["tmp_name"]
            );


            /* Check file type */

            if (!in_array($fileType, $allowedTypes, true)) {

                $error = "Only JPG, PNG and WEBP images are allowed.";

            }

            /* Check file size */

            elseif (
                $_FILES["image"]["size"] > 5 * 1024 * 1024
            ) {

                $error = "Image must be less than 5MB.";

            }

            else {

                /*
                 * Use the ORIGINAL filename.
                 * No uniqid() or generated filename.
                 */
                $imageName = basename(
                    $_FILES["image"]["name"]
                );


                /*
                 * Physical upload folder
                 */
                $uploadDir = __DIR__ . "/../uploads/team/";


                /*
                 * Create folder if it does not exist
                 */
                if (!is_dir($uploadDir)) {

                    mkdir($uploadDir, 0777, true);
                }


                /*
                 * Complete physical file path
                 */
                $uploadPath = $uploadDir . $imageName;


                /*
                 * Upload image
                 */
                if (
                    move_uploaded_file(
                        $_FILES["image"]["tmp_name"],
                        $uploadPath
                    )
                ) {

                    /*
                     * Delete old image
                     *
                     * Only delete it if it is different
                     * from the newly uploaded image.
                     */
                    if (
                        !empty($member["image"]) &&
                        $member["image"] !== $imageName
                    ) {

                        $oldImagePath =
                            $uploadDir . $member["image"];

                        if (file_exists($oldImagePath)) {

                            unlink($oldImagePath);
                        }
                    }

                } else {

                    $error = "Failed to upload image.";
                }
            }
        }


        /* -------------------------------------------------
           UPDATE DATABASE
        ------------------------------------------------- */

        if ($error === "") {

            $stmt = mysqli_prepare(
                $conn,
                "
                UPDATE team
                SET
                    name = ?,
                    position = ?,
                    bio = ?,
                    image = ?
                WHERE id = ?
                "
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssssi",
                $name,
                $position,
                $bio,
                $imageName,
                $id
            );


            if (mysqli_stmt_execute($stmt)) {

                mysqli_stmt_close($stmt);

                header("Location: team.php");

                exit;

            } else {

                $error = "Failed to update team member.";

                mysqli_stmt_close($stmt);
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

    <title>Edit Team Member</title>

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

            <a
                href="team.php"
                class="active"
            >
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


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <div class="admin-container">

        <h1>
            Edit Team Member
        </h1>


        <!-- ERROR MESSAGE -->

        <?php if ($error !== ""): ?>

            <div class="error-message">

                <?php
                echo htmlspecialchars($error);
                ?>

            </div>

        <?php endif; ?>


        <!-- =================================================
             FORM
        ================================================== -->

        <form
            method="POST"
            enctype="multipart/form-data" class="team-form"
        >


            <!-- NAME -->

            <label>
                Name
            </label>

            <input
                type="text"
                name="name"
                value="<?php
                    echo htmlspecialchars($member["name"]);
                ?>"
                required
            >


            <br><br>


            <!-- POSITION -->

            <label>
                Position
            </label>

            <input
                type="text"
                name="position"
                value="<?php
                    echo htmlspecialchars($member["position"]);
                ?>"
                required
            >


            <br><br>


            <!-- BIO -->

            <label>
                Biography
            </label>

            <textarea
                name="bio"
                rows="6"
            ><?php
                echo htmlspecialchars($member["bio"]);
            ?></textarea>


            <br><br>


            <!-- CURRENT IMAGE -->

            <?php if (!empty($member["image"])): ?>

                <p>
                    Current Image:
                </p>

                <img
                    src="../uploads/team/<?php
                        echo htmlspecialchars($member["image"]);
                    ?>"
                    width="150"
                    alt="<?php
                        echo htmlspecialchars($member["name"]);
                    ?>"
                >

                <br><br>

            <?php endif; ?>


            <!-- NEW IMAGE -->

            <label>
                Replace Image
            </label>

            <input
                type="file"
                name="image"
                accept="image/jpeg,image/png,image/webp"
            >


            <br><br>


            <!-- BUTTONS -->

            <button type="submit">
                Update Team Member
            </button>

            <a href="team.php">
                Cancel
            </a>


        </form>

    </div>

</div>

</body>

</html>
