<?php
session_start();
require_once('required_files.php');
header('Content-Type: application/json');
$response = [
    "success" => false,
    "message" => "Une erreur est survenue."
];

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['email']) && isset($_POST['new_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];

    $user = verifyUserLoginAndPassword($email);
    //vérifier si le mail exite
    if ($user !== false) {
        //vérifier que le mot nouveau mot de passe est différent de l'ancien
        if (password_verify($new_password, $user['password'])) {
            $response['message'] = "Le nouveau mot de passe doit être différent de l'ancien. Veuillez réessayer.";
            $response['alerte'] = 'danger';
        } else {
            //requette update du mot de passe
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            if (resetUser($email, $new_password_hash)) {
                $response['success'] = true;
                $response['message'] = 'Votre mot de passe a été modifié avec succès. Vous serez redirigé vers la page de connexion.';
                $response['alerte'] = 'success';
            } else {
                $response['message'] = "Problème survenu dans la tentative de modification du mot de passe. Veuillez réessayer.";
                $response['alerte'] = 'danger';
            }
        }
    } else {
        $response['message'] = "Adresse e-mail non trouvée. Veuillez vérifier et réessayer.";
        $response['alerte'] = 'danger';
    }
} else {
    $response['message'] = "Methode non autorisée";
}
echo json_encode($response);
exit();
