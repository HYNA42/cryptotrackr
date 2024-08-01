<?php
require_once('src/php/libs/required_files.php');
$menu = ["index.php" => 'Accueil', "market.php" => 'Marché', "profil.php" => 'Profil', "login.php" => 'Connexion', "signup.php" => 'Inscription', "logout.php" => 'Déconnexion'];

$page = basename($_SERVER['SCRIPT_NAME'], '.php'); // Récupère le nom de la page sans l'extension
?>

<!DOCTYPE html>
<html lang="fr" class="<?= $page ?>-page">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        // $index = basename($_SERVER['SCRIPT_NAME']);
        if ($page) {
            foreach ($menu as $file => $title) {
                // if($page === $index){echo $title;}
                echo (($file === $page. '.php') ? $title . SITE_NAME : "");
            }
        } else{
            echo (SITE_NAME);
        } 

        ?>
    </title>

    <link rel="stylesheet" href="dist/css/main.min.css">
    <!-- <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css"> -->
    <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.min.css">

</head>