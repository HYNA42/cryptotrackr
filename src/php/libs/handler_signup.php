<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('required_files.php');
header('Content-Type: application/json');

$response = [
    "success" => false,
    "message" => "Une erreur est survenue."
];
if (($_SERVER['REQUEST_METHOD'] === "POST") && issetParams('firstname', 'lastname', 'pseudo', 'birthday', 'email', 'password')) {
    //Récuperer les informations de la requête
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $pseudo = trim($_POST['pseudo']);
    $birthday = new DateTime(trim($_POST['birthday']));
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    //vérifier si l'utilistateur ne dispose pas déjà d'un compte  
    $user = verifyUserLoginAndPassword($email);
    if ($user !== false) {
        $response['success'] = false;
        $response['alerte'] = "danger";
        $response['message'] = "Un compte existe déjà avec cette adresse email : " . htmlspecialchars($email);
    } else {
        // on vérifie l'unicité du pseudo
        if (verifyUserPseudo($pseudo)) {
            $response['success'] = false;
            $response['alerte'] = "danger";
            $response['message'] = htmlspecialchars("\"$pseudo\"") . " est déjà pris, veuillez choisir un pseudo unique";
        } else {
            /**inscrire l'utilisateur Test@2024!
             * signupUser
             * ($firstname,$lastname,$pseudo,$birthday,$email,$password)
             */
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            $signupUser = signupUser($firstname, $lastname, $pseudo, $birthday, $email, $passwordHash);

            if ($signupUser !== false) {
                $response['success'] = true;
                $response['alerte'] = "success";
                $response['message'] = "Félicitations " . htmlspecialchars($pseudo) . " ,votre inscription a été réussie. Vous allez être redirigez vers la page de connexion";
                $response['redirect'] = 'index.php';
            } else {
                $response['message'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer plus tard.";
            }


            // $response['message'] = $params;
        }
    }
} else {
    $response['message'] = "Requête invalide.";
    echo json_encode($response);
    exit();
}


echo json_encode($response);
exit();
