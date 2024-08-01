<!-- Modal -->
<div class="modal fade" id="modalDeleteUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDeleteUserLabel">Je confirme la suppression de mon compte ? </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><span class="badge rounded-pill text-bg-danger">Attention <?= htmlspecialchars($_SESSION['firstname']) ?></span> Cette action est irréversible; vous serez redirigé vers la page de connexion suite à la suppression de votre compte.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteUserBtn">Confirmer</button>
            </div>
        </div>
    </div>
</div>