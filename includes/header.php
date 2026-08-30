<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($pageTitle ?? "Elegance Boutique"); ?>
    </title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<header class="site-header">

    <div class="header-container">

        <!-- Logo -->
        <div class="logo">
            <a href="index.php">
                ELEGANCE BOUTIQUE
            </a>
        </div>


        <!-- Mobile Menu Button -->
        <button
            type="button"
            class="menu-toggle"
            id="menuToggle"
            aria-label="Toggle navigation"
        >
            ☰
        </button>


        <!-- Navigation -->
        <nav class="navbar" id="navbar" hidden>

            <a href="index.php">Home</a>

            <a href="about.php">About</a>

            <a href="products.php">Products</a>

            <a href="gallery.php">Gallery</a>

            <a href="contact.php">Contact</a>

        </nav>

    </div>

</header>
<script>
const menuToggle = document.getElementById("menuToggle");
const sidebar = document.querySelector(".sidebar");

menuToggle.addEventListener("click", function () {
    sidebar.classList.toggle("sidebar-open");
});
</script>

<script>
// const menuToggle = document.getElementById("menuToggle");
// const navbar = document.getElementById("navbar");
// menuToggle.onclick = function () {

//     navbar.classList.toggle("active");

//     console.log(navbar.className);

// };
// // menuToggle.onclick = function () {
// //     navbar.classList.toggle("active");

    
// // };
// </script>
<!-- <script>
const menuToggle = document.getElementById("menuToggle");
const navbar = document.getElementById("navbar");

menuToggle.onclick = function () {
    navbar.classList.toggle("active");
};
</script> -->

<main>


<!-- <script>
document.addEventListener("DOMContentLoaded", function () {

    const menuToggle = document.getElementById("menuToggle");
    const navbar = document.getElementById("navbar");

    if (!menuToggle || !navbar) {
        console.log("Menu elements not found");
        return;
    }

    menuToggle.addEventListener("click", function () {
        console.log("CLICKED");
        navbar.classList.toggle("active");

    });

});
</script> -->