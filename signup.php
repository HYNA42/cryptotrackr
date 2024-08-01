<?php
session_start();
// require_once('src/php/libs/required_files.php');
require_once('src/php/templates/header.php');
?>


<div class="row align-items-center vh-100 _signup">
    <div class="col content-form">

        <?php
        require_once(TEMPLATE_PATH . 'renderForm.php');

        renderForm(
            '_signup',
            "S'inscrire",
            [
                $fiedlsFirstName,
                $fiedlsLastName,
                $fiedlsUsername, 
                $fiedlsBirthDate, 
                $fiedlsEmail, 
                $fiedlsPassword,
            ]
        );

        ?>

    </div>
</div>




<?php
require_once(TEMPLATE_PATH . 'footer.php');
?>

<!-- 
        $fiedlsFirstName,
        $fiedlsLastName,
        $fiedlsUsername, 
        $fiedlsBirthDate, 
        $fiedlsEmail, 
        $fiedlsPassword,
-->