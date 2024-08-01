<?php
session_start();
header('Content-Type: application/json');
require_once('required_files.php');

// Initialisation de la réponse
$response = [
    "success" => false,
    "message" => "Une erreur est survenue.",
    "alert" => ""
];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_FILES['inputPhoto'])) {
        //Récuperer les informations du fichier
        $file = $_FILES['inputPhoto'];
        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileType = $file['type'];

        $fileNameCmps  = explode(".", $fileName);
        $fileExtension  = strtolower(end($fileNameCmps));

        $newFilename = $_SESSION['pseudo'] . ".png";

        //définir les extensions autorisées
        $allowedExtensions = ['jpg', 'gif', 'png', 'jpeg'];
        // $allowedExtensions = ['jpg', 'gif',  'jpeg'];

        if (in_array($fileExtension, $allowedExtensions) && isset($fileName)) {

            $uploadFileDir = "../../db/img/";
            $dest_path = $uploadFileDir . $newFilename;

            $response['alert'] = "success";
            $response['message'] = $newFilename . " téléchargée avec succès, nouveau url : " . $dest_path;


            // Mettre à jour le chemin dans la base de données
            $email = $_SESSION['email'];
            $newDirPicture = '/src/db/img/' . $newFilename;
            if (updateProfilPicture($email, $newDirPicture)) {
                // session_regenerate_id(true);
                $uploaded = move_uploaded_file($fileTmpPath, $dest_path);
                // Mettre à jour la session après le téléchargement
                $_SESSION['profil_picture'] = $newDirPicture;
            }

            // $uploaded = true;
            if ($uploaded) {

                $_SESSION['alert'] = "success";
                $_SESSION['message'] = " Votre photo de profil a été modifié avec succès";

                $response['alert'] = $_SESSION['alert'];
                $response['message'] =  $_SESSION['message'];

                $response['newProfilePictureUrl'] = $newDirPicture;

            } else {
                $_SESSION['alert'] = "danger";
                $_SESSION['message'] = "Une erreur est survenue lors du téléchargement du fichier ...";

                $response['alert'] =  $_SESSION['alert'];
                $response['message'] = $_SESSION['message'];
            }
        } else {
            $response['alert'] = "warning";
            $response['message'] = "Type de fichier non reconnu, formats acceptés :" . implode(',', $allowedExtensions);
        }
    } else {
        $response['message'] = "Données FILES manquantes.";
    }
} else {
    $response['message'] = "Méthode de requête non autorisée.";
}

echo json_encode($response);
exit;
