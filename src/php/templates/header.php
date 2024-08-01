<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('src/php/libs/required_files.php');
require_once('head.php');
// Déterminer si l'utilisateur est connecté
$isLoggedIn = isset($_SESSION['email']);
?>
<body class="body">
    <div class="d-flex flex-column min-vh-100">
        <header class="mb-auto fixed-top">
            <nav class="navbar navbar-expand-lg border-bottom border-body">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">
                        <img src="<?= IMG_URL ?>logo.png" alt="Logo">
                        CryptoTrackr
                    </a>
                    <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <?php if (!$isLoggedIn) : ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= basename($_SERVER['SCRIPT_NAME']) === 'index.php' ? 'active' : '' ?>" href="index.php">Accueil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= basename($_SERVER['SCRIPT_NAME']) === 'market.php' ? 'active' : '' ?>" href="market.php">Marché</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link <?= basename($_SERVER['SCRIPT_NAME']) === 'profil.php' ? 'active' : '' ?>" href="profil.php">Profil</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLogin" aria-controls="offcanvasLogin">Connexion</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="signup.php">Inscription</a>
                                </li>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a class="nav-link <?= basename($_SERVER['SCRIPT_NAME']) === 'market.php' ? 'active' : '' ?>" href="market.php">Marché</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?= basename($_SERVER['SCRIPT_NAME']) === 'profil.php' ? 'active' : '' ?>" href="profil.php">Profil</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="#" id="logoutBtn">Déconnexion</a>
                                </li>
                            <?php endif; ?>


                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <?php require_once(TEMPLATE_PATH . 'offcanvas.php'); ?>
        <main class="main container">