<?php

//  on définit les différents champs possible pour nos formulaires de connexion et d'inscription 

$fiedlsEmail = ['titre' => "Email", 'type' => "email", 'name' => 'email', 'classIcone' => "bi bi-envelope-fill"];
$fiedlsPassword = ['titre' => "Mot de passe", 'type' => "password", 'name' => 'password', 'classIcone' => "bi bi-key-fill"];

$fiedlsFirstName = ['titre' => "Prénom", 'type' => "text", 'name' => 'firstname', 'classIcone' => 'bi bi-person-fill'];

$fiedlsLastName = ['titre' => 'Nom', 'type' => 'text', 'name' => 'lastname', 'classIcone' => 'bi bi-person-fill'];

$fiedlsUsername = ['titre' => 'Pseudo', 'type' => 'text', 'name' => 'pseudo', 'classIcone' => 'bi bi-person-fill'];

$fiedlsBirthDate = ['titre' => 'Date de naissance', 'type' => 'date', 'name' => 'birthday', 'classIcone' => 'bi bi-calendar3'];

//Reset
$reset_fiedlsEmail = ['titre' => "Email", 'type' => "email", 'name' => 'email', 'classIcone' => "bi bi-envelope-fill"];
$reset_fiedlsNewPassword = ['titre' => "Nouveau Mot de passe", 'type' => "password", 'name' => 'new_password', 'classIcone' => "bi bi-key-fill"];
$reset_fiedlsConfirmNewPassword = ['titre' => "Confirmation du mot de passe", 'type' => "password", 'name' => 'confirm_password', 'classIcone' => "bi bi-key-fill"];


/**
 * titre => Email 
 * type => pour attribut for et id 
 * classIcone => classe font Icone Bootstrap 
 */

function renderForm(string $suffix = '', string $btnAction = "Se connecter", array $fields = [])
{ ?>
    <form action="" method="post" class="align-items-center form" id="<?= $suffix; ?>Form">

        <!-- boucle sur les champs du formulaire pour créer les éléments de façon dynamique -->
        <?php foreach ($fields as $field) { ?>
            <div>
                <label for="<?= $field['name'] . $suffix; ?>" class="form-label">
                    <i class="<?= $field['classIcone']; ?>"></i> <?= $field['titre']; ?>
                </label>
                <input type="<?= $field['type']; ?>" name="<?= $field['name']; ?>" id="<?= $field['name'] . $suffix; ?>" class="form-control" required placeholder="<?= $field['titre']; ?> (obligatoire)">
            </div>

        <?php } ?>

        <!-- accepter les conditions d'utilisation si inscription-->
        <?php if (strpos($suffix, "_signup") === 0) { ?>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" required>
                <label class="form-check-label login_or_signup_message" for="flexSwitchCheckChecked">Je certifie être âgé(e)de 18 ans ou plus, accepter le <a href="#">Contrat d'utilisateur</a> et avoir lu la <a href="#">Politique de confidentialité</a>.</label>
            </div>
        <?php } ?>

        <!-- Bouton connexion ou inscription -->
        <div>
            <input type="submit" class="btn btn-primary" value="<?= $btnAction; ?>" name="<?= $suffix; ?>" id="<?= $suffix; ?>">
        </div>

        <!-- inviter l'utilisateur à s'inscrire si besoin -->

        <?php if (str_starts_with($suffix, "_login")) { ?>
            <div class="login_or_signup_message  mb-3 d-flex flex-column gap-2">
                <span>Vous n'avez pas un compte ? <a href="signup.php">S'inscrire</a></span>

                <span><a href="password_reset.php">Mot de passe oublié ?</a></span>
            </div>
        <?php } ?>

        <!-- message d'alerte -->
        <div id="alerte<?= $suffix; ?>">

        </div>

        <!--| alerte_loginUserHome,  alerte_loginUserOffcanvas, alerte_signup  |-->
    </form>




<?php } ?>