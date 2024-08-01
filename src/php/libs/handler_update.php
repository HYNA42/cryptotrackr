<?php
session_start();
require_once('required_files.php');
header('Content-Type: application/json');
$response = [
    "success" => false,
    "message" => "Une erreur est survenue."
];

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['password'])) {
    $currentEmail = $_SESSION['email'];
    //Test@2024!+1
    //Test@2024!
    $user = verifyUserLoginAndPassword($currentEmail);
    if (password_verify($_POST['password'], $user['password'])) {
        //vérification du mot de passe
        $id = $_SESSION['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $pseudo = $_POST['pseudo'];
        $birthday = new DateTime($_POST['birthday']);
        $email = $_POST['email'];



        if (isset($_POST['new_password'])) {
            $newPassword = $_POST['new_password'];
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            $UserIsUpdated = updateUserInformations($id, $firstname, $lastname, $pseudo, $birthday, $email, $newPasswordHash);
        } else {
            $UserIsUpdated = updateUserInformations($id, $firstname, $lastname, $pseudo, $birthday, $email);
        }


        if ($UserIsUpdated) {
            //déconnexion de l'utilisateur
            logout_session();
            $response['success'] = true;
            $response['alerte'] = 'success';
            $response['message'] = 'Vos informations ont été mises à jour avec succès. Veuillez vous reconnecter';
            //redirection vers la page de connexion
            $response['redirect'] = 'index.php';
            
        } else {
            $response['message'] = 'Une erreur est survenue lors de la mise à jour de vos informations.';
            $response['alerte'] = 'danger';
        }
    } else {
        $response['message'] = 'Mot de passe incorrect';
        $response['alerte'] = 'danger';
    }
} else {
    $response['message'] = "Methode non autorisée";
}
echo json_encode($response);
exit();
