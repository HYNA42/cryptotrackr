<?php
session_start();
// require_once('src/php/libs/required_files.php');
require_once('./src/php/templates/header.php');
// ---------------------HEADER----------------------------
$isLoggedIn = isset($_SESSION['email']);

?>

<!-- <h1>Hello Word</h1> -->
<div class="d-flex align-items-center vh-100 ">
  <div class="row row-cols-1 row-cols-md-2 accueil <?= is_logged_session() ? 'logged-in' : ''; ?>">

    <div class="col accueil--left">
      <div class="content">
        <h1>Bienvenue sur CoinTrackr !</h1>
        <p> Votre compagnon idéal pour naviguer dans le monde fascinant des cryptomonnaies. Nous sommes ravis de vous accueillir dans notre communauté où vous pouvez suivre vos investissements, rester informé des dernières tendances et gérer vos actifs numériques en toute simplicité.</p>
        <div class="line"></div>

        <p>Profitez de notre interface intuitive pour explorer les fluctuations du marché et prendre des décisions éclairées. Que vous soyez un investisseur chevronné ou un débutant curieux, CoinTracker est là pour vous accompagner à chaque étape de votre parcours cryptographique.</p>
        <div class="line"></div>

        <p>Commencez dès maintenant en explorant le marché dans l'onglet "Marché", où vous trouverez toutes les cryptomonnaies avec leurs informations détaillées.
        </p>
        <div class="line"></div>

        <p>Pour accéder à votre tableau de bord personnalisé, où vous pouvez suivre et gérer vos cryptomonnaies favorites, veuillez vous connecter ou créer un compte.
        </p>
        <div class="line"></div>

        <span class="signature">CoinTrackr- Explorez la crypto en toute simplicité.</span>
      </div>
    </div>
    <?php if (!is_logged_session()) : ?>
      <div class="col accueil--right">
        <div class="row justify-content-center align-items-center h-100 ">
          <div class="col-md-8">
            <?php
            require_once(TEMPLATE_PATH . 'renderForm.php');

            renderForm(
              '_loginUserHome',
              'Se connecter',
              [
                $fiedlsEmail, $fiedlsPassword
              ]
            );

            ?>
          </div>
        </div>

      </div>
    <?php endif ?>

  </div>

  <!-- <div class="offcanvasLogin">
    //le offcanvas est ajouté dans le header pour etre disponible dans toutes les pages
  </div> -->
</div>


<!-- -----------------------FOOTER---------------- -->
<?php
require_once(TEMPLATE_PATH . 'footer.php');
?>