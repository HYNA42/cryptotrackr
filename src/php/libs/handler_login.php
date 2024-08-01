<?php
session_start();
require_once('required_files.php');
header('Content-Type: application/json');
$response = [
    "success" => false,
    "message" => "Une erreur est survenue."
];

if ($_SERVER['REQUEST_METHOD'] === "POST" && issetParams('email', 'password')) {
    //Récuperer les informations de la requête
    $email = $_POST['email'];
    $password = $_POST['password'];

    $response = [
        "success" => false,
        "message" => "Contact établie"
    ];

    //vérifier les identifiants de l'utilisateur 
    $user = verifyUserLoginAndPassword($email, $password);

    if ($user) {
        //lorsque l'authentification est réussie
        $_SESSION['id'] = $user['id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['pseudo'] = $user['pseudo'];
        $_SESSION['birthday'] = $user['birthday'];
        $_SESSION['email'] = $user['email'];
        // $_SESSION['password'] = $user['password'];
        $_SESSION['profil_picture'] = $user['profil_picture'];

        $response['success'] = true;
        $response['message'] = "Authentification réussi SESSION started";
        // + une clé pour indiquer la redirection
        $response['redirect'] = "market.php";
    } else {
        //authentification non réussie : alerte
        $response['message'] = "Email ou mot de passe incorrect";
        $response['alerte'] = "danger";
    }

    //////////////////////// 

} else {
    $response['message'] = "Requête invalide.";
    exit();
}
echo json_encode($response);
