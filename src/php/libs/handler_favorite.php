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
if (($_SERVER['REQUEST_METHOD'] === "POST") && issetParams('cryptoId')) {
    //Récuperer les informations de la requête
    $cryptoId = $_POST['cryptoId'];
    $userId = $_SESSION['id'];
    $crypto = isCryptoFavorite($cryptoId, $userId);
    if ($crypto) {
        //la crypo existe déjà en favoris => à retirer
        if (deleteUserCryptoFavorite($cryptoId, $userId)) {
            $response['success'] = true;
            $response['alert'] = "delete";
            $response['message'] = "Favoris retiré";
        } else {
            $response['message'] = "Erreur suppression favoris";
        }
    } else {
        //la crypo n'existe pas en favoris => à ajouter
        if (addUserCryptoFavorite($cryptoId, $userId)) {
            $response['success'] = true;
            $response['alert'] = "add";
            $response['message'] = "Favoris ajouté ";
        } else {
            $response['message'] = "Erreur ajout favoris";
        }
    }
} else {
    $response['message'] = "Requête invalide.";
    echo json_encode($response);
    exit();
}


echo json_encode($response);
exit();




/**
 * cherche crypto
 * -> avec le userID = SELECT * FROM `preference` WHERE user_id ='e978470-46ed-11ef-b303-70b5e8c11b91';
 * 
 * ->avec le pseudo par exemple (jointure)
 * SELECT c.*
 * FROM `preference` p 
 * JOIN `user` u ON p.user_id=u.id
 * JOIN `cryptocurrency` c ON p.cryptocurrency_id=c.id
 * WHERE u.user_id = '$userId';
 * 
 */

//  "GO UserId = 2e978470-46ed-11ef-b303-70b5e8c11b91 CryptoId =  b6a55a17-43d5-11ef-9a16-70b5e8c11b91"