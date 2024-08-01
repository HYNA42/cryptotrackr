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
    // Vérifier l'état de la session avant de la détruire
    if (session_status() === PHP_SESSION_ACTIVE) {
        //détruire la session
        logout_session();
        // Vérifier si la session est bien détruite
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $response['success'] = true;
            $response['message'] = "Déconnexion réussie.";
            $response['redirect'] = "index.php";
        } else {
            $response['message'] = "Échec de la déconnexion.";
        }
    } else {
        $response['message'] = "Aucune session active";
    }
} else {
    $response['message'] = "Methode non autorisée";
}
echo json_encode($response);
exit();