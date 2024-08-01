<?php
session_start();
require_once('required_files.php');
// Initialisation de la réponse
header('Content-Type: application/json');
$response = [
    "success" => false,
    "message" => "Une erreur est survenue."
];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $sessions = ['id' => $_SESSION['id'], 'email' => $_SESSION['email'], 'pseudo' => $_SESSION['pseudo']];

    //vérifier la connexion
    if (isset($sessions)) {

        // supprimer tous les favoris
        $deleteAllFavorites = deleteUserCryptoFavorite(null, $sessions['id']);
        if ($deleteAllFavorites) {
            $delete = deleteUser($sessions['email']);
            // deleteUser($sessions['email'])
            if ($delete) {
                $response['success'] = true;
                $response['message'] = "Le compte utilisateur bien été supprimé";
                $response['pseudo'] = $sessions['pseudo'];
                //redirection à la page de connexion
                $response['redirect'] = "index.php";
                //detruire la session
                logout_session();
            } else {
                $response['message'] = "La suppression du compte a échouée";
            }
        } else {
            $response['message'] = "Probleme dans la tentative de suppression des favoris";
        }
    } else {
        $response['message'] = "Utilisateur non connecté";
    }
} else {
    $response['message'] = "Methode non autorisée";
}
echo json_encode($response);
exit();
