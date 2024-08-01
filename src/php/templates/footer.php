<?php
require_once('src/php/libs/required_files.php');
$items = ['© 2024 - CryptoTrackr', 'Contact', 'A propos', 'Mentions légales'];
$socials = ['facebook.png', 'whatsapp.png', 'twitter.png', 'linkedin.png', 'instagram.png'];
// var_dump($_SERVER);

?>

</main>

<footer class="footer mt-auto">

    <div class="container-fluid d-lg-flex">
        <ul class="nav align-items-center --items">
            <a class="navbar-brand" href="index.php">
                <img src="<?= IMG_URL ?>logo.png" alt="Logo">
                <!-- <span> © 2024 - CryptoTrackr</span> -->
            </a>
            <?php
            foreach ($items as $item) { ?>

                <li class="nav-item"><a href="" class="nav-link"><?= $item; ?></a></li>

            <?php } ?>
        </ul>
        <ul class="nav align-items-center d-flex justify-content-center --socials">

            <?php foreach ($socials as $social) {
                $suffix = '.png';
                $socialname = basename(IMG_URL . $social, $suffix);
            ?>

                <li>
                    <a href="#">
                        <img src="<?= IMG_URL ?><?= $social; ?>" alt="Logo <?= $socialname; ?>">
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

</footer>

</div>
<!-- Inclure Bootstrap JavaScript -->


<script src="<?= BASE_URL ?>node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<script src="<?= JS_URL ?>main.js" type="module" defer></script>

<script src="<?= JS_URL ?>crypto.js" type="module" defer></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>

</body>

</html>