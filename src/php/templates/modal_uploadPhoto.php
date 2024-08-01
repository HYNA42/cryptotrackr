<div class="modal fade" id="modalUploadPhoto" tabindex="-1" aria-labelledby="modalUploadPhotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalUploadPhotoLabel">Choisir une photo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="uploadPhotoForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input class="form-control" type="file" id="inputPhoto" name="inputPhoto" accept="image/*">

                    <span id="alertInputPhoto">
                        <!-- alerte si aucune image selectionnée -->
                    </span>


                    <div id="imagePreview" class="text-center"></div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="modifyPhoto">Enregistrer</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

                </div>
            </form>
        </div>
    </div>
</div>