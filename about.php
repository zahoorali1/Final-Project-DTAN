<?php

require_once "config/database.php";

$pageTitle = "About | Elegance Boutique";


// Get team members
$sql = "
    SELECT *
    FROM team
    ORDER BY id
";

$result = mysqli_query($conn, $sql);

$team = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $team[] = $row;
    }
}


include "includes/header.php";

?>


<section class="page-banner">

    <p class="eyebrow">
        OUR STORY
    </p>

    <h1>
        About Elegance
    </h1>

    <p>
        Fashion designed around confidence,
        comfort and individuality.
    </p>

</section>


<section class="section two-col">
    
    <div>

        <p class="eyebrow">
            THE BOUTIQUE
        </p>

        <h2>
            Style with a personal touch.
        </h2>

        <p>
            Elegance Boutique is a modern
            clothing destination bringing together
            carefully selected everyday and
            occasion wear.
        </p>

        <p>
            We believe great style should feel
            effortless, comfortable and uniquely yours.
        </p>

        <p>
            From elegant dresses to versatile shirts,
            trousers and scarves, every piece is
            selected with quality and contemporary
            fashion in mind.
        </p>

    </div>




    <div class="about-box">

        
        <h3>
            Our Mission
        </h3>

        <p>
            To make beautiful, wearable fashion
            accessible while giving every customer
            a welcoming boutique experience.
        </p>


        <h3>
            Our Values
        </h3>

        <ul>

            <li>
                Quality first
            </li>

            <li>
                Personal service
            </li>

            <li>
                Confident individuality
            </li>

            <li>
                Timeless style
            </li>

        </ul>

    </div> 

    <div class="demo-notice"> <h3>Project Demonstration</h3> 
        <p> <strong>Elegance Boutique</strong> is a demo business website created
         for academic project demonstration purposes. The business information,
          products, and content presented on this website are fictional 
        and are used to demonstrate the functionality and design of the system. 
        </p> 
        <div>


</section>


<section class="section muted">

    <div class="section-title">

        <p class="eyebrow">
            MEET US
        </p>

        <h2>
            Our Team
        </h2>

    </div>


    <div class="team-grid">

        <?php foreach ($team as $member): ?>

            <div class="team-card">

<img
    src="uploads/team/<?= htmlspecialchars($member['image']) ?>"
    alt="<?= htmlspecialchars($member['name']) ?>"
>

                <h3>
                    <?= htmlspecialchars($member['name']) ?>
                </h3>

                <p class="small">
                    <?= htmlspecialchars($member['position']) ?>
                </p>

                <p>
                    <?= htmlspecialchars($member['bio']) ?>
                </p>

            </div>

        <?php endforeach; ?>

    </div>

</section>


<?php

include "includes/footer.php";

?>