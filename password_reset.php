<?php
session_start();
// require_once('src/php/libs/required_files.php');
require_once('src/php/templates/header.php');
?>


<div class="row align-items-center vh-100 _reset">
    <div class="col content-form">
        <?php
        require_once(TEMPLATE_PATH . 'renderForm.php');

        renderForm(
            '_reset',
            "Confirmer",
            [
                $fiedlsEmail, $reset_fiedlsNewPassword, $reset_fiedlsConfirmNewPassword
            ]
        );

        ?>
    </div>

    <!--Ajouter ici les différentes conditions de liées au reset.php -->

</div>





<?php
require_once(TEMPLATE_PATH . 'footer.php');
?>