<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION["admin_id"])) {
    header("Location: ../login.php");
    exit;
}

$query = "
    SELECT *
    FROM team
    ORDER BY id DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database error: " . mysqli_error($conn));
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

    <title>Manage Team | Elegance Boutique</title>

    <!-- If admin.css is inside the admin folder -->
    <!-- <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"> -->
    <link rel="stylesheet" href="admin.css">

</head>

<body>

<div class="admin-layout">


    <!-- =========================================
         SIDEBAR
    ========================================== -->

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

            <!-- TEAM IS ACTIVE -->
            <a href="team.php" class="active">
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


    <!-- =========================================
         MAIN CONTENT
    ========================================== -->

    <main class="admin-container">

        <div class="admin-header">

            <h1>Manage Team</h1>

            <a href="team_add.php" class="btn">
                + Add Team Member
            </a>

        </div>


        <!-- =========================================
             TEAM TABLE
        ========================================== -->

        <div class="table-wrapper">

            <table class="admin-table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>Image</th>

                        <th>Name</th>

                        <th>Position</th>

                        <th>Actions</th>

                    </tr>

                </thead>

                <tbody>

                <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php while ($member = mysqli_fetch_assoc($result)): ?>

                        <tr>

                            <td>
                                <?php echo $member["id"]; ?>
                            </td>




<td>

<?php if (!empty($member["image"])): ?>

    <img
        src="../uploads/team/<?php echo htmlspecialchars($member["image"]); ?>"
        class="team-image"
        alt="<?php echo htmlspecialchars($member["name"]); ?>"
    >

<?php else: ?>

    <span class="no-image">
        No Image
    </span>

<?php endif; ?>

</td>



                            <td>
                                <?php echo htmlspecialchars($member["name"]); ?>
                            </td>


                            <td>
                                <?php echo htmlspecialchars($member["position"]); ?>
                            </td>


                            <td>

                                <div class="action-buttons">

                                    <a
                                        href="team_edit.php?id=<?php echo $member["id"]; ?>"
                                        class="edit-btn"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="team_delete.php?id=<?php echo $member["id"]; ?>"
                                        class="delete-btn"
                                        onclick="return confirm('Are you sure you want to delete this team member?');"
                                    >
                                        Delete
                                    </a>

                                </div>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="5" class="empty-message">
                            No team members found.
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