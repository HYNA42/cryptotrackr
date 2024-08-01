<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="offcanvasProfil" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="staticBackdropLabel">Modifier mes informations personnelles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="update_user_info.php" method="POST" id="_updateUserInfosForm">
            <div>
                <label for="firstname" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?= htmlspecialchars($userInfos['firstname']); ?>" required>
            </div>
            <div>
                <label for="lastname" class="form-label">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?= htmlspecialchars($userInfos['lastname']); ?>" required>
            </div>
            <div>
                <label for="pseudo" class="form-label">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= htmlspecialchars($userInfos['pseudo']); ?>" required>
            </div>
            <div>
                <label for="birthday" class="form-label">Anniversaire</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="<?= htmlspecialchars($_SESSION['birthday']); ?>" required>
            </div>
            <div>
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userInfos['email']); ?>" required>
            </div>
            <div>
                <label for="password" class="form-label">Mot de passe actuel </label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="(obligatoire)">
            </div>


            <div>
                <label for="new_password" class="form-label">Nouveau mot de passe <small>(laisser vide si inchangé)</small></label>
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Laisser vide si inchangé">
            </div>
            <div>
                <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Laisser vide si inchangé">
            </div>

            <button type="submit" class="btn btn-primary">Valider les modifications</button>
        </form>
        <div id="alerte_update"></div>
    </div>
</div>