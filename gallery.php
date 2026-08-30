<?php

require_once "config/database.php";

$pageTitle = "Gallery | Elegance Boutique";


// Get gallery items

$sql = "
    SELECT *
    FROM gallery
    ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

$gallery = [];

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $gallery[] = $row;

    }

}


include "includes/header.php";

?>


<section class="page-banner">

    <p class="eyebrow">
        VISUAL JOURNAL
    </p>

    <h1>
        Gallery
    </h1>

    <p>
        A glimpse into our boutique
        and latest collections.
    </p>

</section>


<section class="section">

    <div class="gallery-grid">

        <?php foreach ($gallery as $item): ?>

            <figure>

                <img
                    src="<?= htmlspecialchars($item['image']) ?>"
                    alt="<?= htmlspecialchars($item['title']) ?>"
                >

                <figcaption>

                    <strong>
                        <?= htmlspecialchars($item['title']) ?>
                    </strong>

                    <span>
                        <?= htmlspecialchars($item['description']) ?>
                    </span>

                </figcaption>

            </figure>

        <?php endforeach; ?>

    </div>

</section>


<?php

include "includes/footer.php";

?>