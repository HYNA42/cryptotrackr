<div class="collapse" id="collapseTableFields">
    <div class="table_fields">
        <table class="table table-striped table-hover table-bordered ">
            <thead>
                <tr>
                    <?php foreach ($userInfosTitles as $title) : ?>
                        <th scope="col"><?= htmlspecialchars($title); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($userInfos['firstname']); ?></td>
                    <td><?= htmlspecialchars($userInfos['lastname']); ?></td>
                    <td><?= htmlspecialchars($userInfos['email']); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- ----------- -->
    <div class="buttons">
        <!-- <p>Helo</p> -->

        <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasProfil" aria-controls="staticBackdrop">
            Modifier
        </button>

        <button class="btn btn-danger" href="#" type="button" id="deleteUserBtn">Supprimer</button>

        <!-- modal confirmer/annuler suppression de compte -->
        <?php require_once('src/php/templates/modal_deleteUser.php') ?>


    </div>
    <div class="offcanvasProfil">
        <!-- offcanvas pour mettre a jour les infos user -->
        <?php require_once(TEMPLATE_PATH . 'offcanvasUpdateInfosUser.php'); ?>
    </div>
</div>