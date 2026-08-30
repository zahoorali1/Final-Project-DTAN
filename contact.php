<?php

require_once "config/database.php";

$pageTitle = "Contact | Elegance Boutique";

$success = "";
$error = "";


/*
|--------------------------------------------------------------------------
| Handle Contact Form
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {


    /*
    |--------------------------------------------------------------------------
    | Get Form Data
    |--------------------------------------------------------------------------
    */

    $name = trim(
        $_POST["name"] ?? ""
    );

    $email = trim(
        $_POST["email"] ?? ""
    );

    $phone = trim(
        $_POST["phone"] ?? ""
    );

    $message = trim(
        $_POST["message"] ?? ""
    );


    /*
    |--------------------------------------------------------------------------
    | Validate Required Fields
    |--------------------------------------------------------------------------
    */

    if ($name === "") {

        $error = "Please enter your name.";

    } elseif ($email === "") {

        $error = "Please enter your email.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } elseif ($message === "") {

        $error = "Please enter your message.";

    }


    /*
    |--------------------------------------------------------------------------
    | Insert Message
    |--------------------------------------------------------------------------
    */

    if ($error === "") {


        $stmt = mysqli_prepare(
            $conn,

            "INSERT INTO messages
            (
                name,
                email,
                phone,
                message
            )

            VALUES (?, ?, ?, ?)"
        );


        if (!$stmt) {

            $error =
                "Database error: "
                . mysqli_error($conn);

        } else {


            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $name,
                $email,
                $phone,
                $message
            );


            if (
                mysqli_stmt_execute($stmt)
            ) {

                $success =
                    "Thank you! Your message has been sent successfully.";

                /*
                |--------------------------------------------------------------------------
                | Clear Form
                |--------------------------------------------------------------------------
                */

                $name = "";
                $email = "";
                $phone = "";
                $message = "";

            } else {

                $error =
                    "Unable to send your message. Please try again.";

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
        <?= htmlspecialchars($pageTitle) ?>
    </title>


    <link
        rel="stylesheet"
        href="assets/css/style.css"
    >

</head>


<body>


<?php include "includes/header.php"; ?>


<!-- =====================================================
     CONTACT HERO
====================================================== -->

<section class="page-hero">

    <div class="page-hero-content">

        <p class="eyebrow">
            GET IN TOUCH
        </p>

        <h1>
            Contact Us
        </h1>

        <p>
            We'd love to hear from you.
            Visit our boutique or send us a message.
        </p>

    </div>

</section>



<!-- =====================================================
     CONTACT SECTION
====================================================== -->

<section class="contact-section">

    <div class="contact-container">


        <!-- =================================================
             CONTACT INFORMATION
        ================================================== -->

        <div class="contact-info">


            <p class="eyebrow">
                ELEGANCE BOUTIQUE
            </p>


            <h2>
                Let's Talk
            </h2>


            <p class="contact-intro">

                Whether you have a question about our
                collections, need help choosing an outfit,
                or simply want to visit us, we're here to help.

            </p>



            <!-- ADDRESS -->

            <div class="contact-detail">


                <div class="contact-icon">
                    ◇
                </div>


                <div>

                    <h3>
                        Visit Us
                    </h3>

                    <p>
                        Hazara Town<br>
                        Quetta, Pakistan
                    </p>

                </div>


            </div>



            <!-- PHONE -->

            <div class="contact-detail">


                <div class="contact-icon">
                    ☎
                </div>


                <div>

                    <h3>
                        Phone
                    </h3>

                    <p>
                        +92 XXX XXXXXXX
                    </p>

                </div>


            </div>



            <!-- EMAIL -->

            <div class="contact-detail">


                <div class="contact-icon">
                    ✉
                </div>


                <div>

                    <h3>
                        Email
                    </h3>

                    <p>
                        info@eleganceboutique.com
                    </p>

                </div>


            </div>



            <!-- BUSINESS HOURS -->

            <div class="contact-detail">


                <div class="contact-icon">
                    ◷
                </div>


                <div>

                    <h3>
                        Opening Hours
                    </h3>

                    <p>

                        Monday – Saturday<br>
                        10:00 AM – 8:00 PM

                    </p>

                </div>


            </div>


        </div>



        <!-- =================================================
             CONTACT FORM
        ================================================== -->

        <div class="contact-form-wrapper">


            <div class="contact-form-heading">

                <p class="eyebrow">
                    SEND A MESSAGE
                </p>

                <h2>
                    We'd Love To Hear From You
                </h2>

            </div>



            <!-- SUCCESS -->

            <?php if ($success !== ""): ?>

                <div class="form-message success">

                    <?= htmlspecialchars(
                        $success
                    ) ?>

                </div>

            <?php endif; ?>



            <!-- ERROR -->

            <?php if ($error !== ""): ?>

                <div class="form-message error">

                    <?= htmlspecialchars(
                        $error
                    ) ?>

                </div>

            <?php endif; ?>



            <form
                method="POST"
                action=""
                class="contact-form"
            >


                <!-- NAME -->

                <div class="form-group">


                    <label for="name">

                        Your Name *

                    </label>


                    <input
                        type="text"
                        id="name"
                        name="name"

                        value="<?= htmlspecialchars(
                            $name ?? ""
                        ) ?>"

                        placeholder="Enter your name"

                        required
                    >


                </div>



                <!-- EMAIL -->

                <div class="form-group">


                    <label for="email">

                        Email Address *

                    </label>


                    <input
                        type="email"
                        id="email"
                        name="email"

                        value="<?= htmlspecialchars(
                            $email ?? ""
                        ) ?>"

                        placeholder="Enter your email"

                        required
                    >


                </div>



                <!-- PHONE -->

                <div class="form-group">


                    <label for="phone">

                        Phone Number

                    </label>


                    <input
                        type="tel"
                        id="phone"
                        name="phone"

                        value="<?= htmlspecialchars(
                            $phone ?? ""
                        ) ?>"

                        placeholder="Enter your phone number"
                    >


                </div>



                <!-- MESSAGE -->

                <div class="form-group">


                    <label for="message">

                        Message *

                    </label>


                    <textarea
                        id="message"
                        name="message"
                        rows="7"

                        placeholder="How can we help you?"

                        required
                    ><?= htmlspecialchars(
                        $message ?? ""
                    ) ?></textarea>


                </div>



                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="contact-submit"
                >

                    Send Message

                </button>


            </form>


        </div>


    </div>

</section>



<!-- =====================================================
     FOOTER
====================================================== -->

<?php include "includes/footer.php"; ?>


</body>

</html>