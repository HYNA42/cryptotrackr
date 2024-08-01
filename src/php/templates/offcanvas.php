<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasLogin" aria-labelledby="offcanvasLoginLabel">
    <div class="offcanvas-header">
        <!-- <h5 class="offcanvas-title" id="offcanvasLoginLabel">Connexion</h5> -->
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php
        require_once('renderForm.php');
        // renderForm('offCanvas', "Se connecter");
        renderForm(
            '_loginUserOffcanvas',
            'Se connecter',
            [
                $fiedlsEmail, $fiedlsPassword
            ]
        );
        ?>
    </div>
</div>