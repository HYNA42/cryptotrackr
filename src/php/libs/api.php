<?php
function fetchApiCC($url): array
{
    // Initialisation de cURL
    $ch = curl_init();
    // Configuration des options de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CAINFO, "C:/myWAMP/php/extras/ssl/cacert.pem");
    /**------------------------------------ */

    // Exécution de la requête cURL
    $response = curl_exec($ch);
    //vérification des erreurs cURL
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ["error" => $error_msg];
    }

    //fermeture de cURL
    curl_close($ch);

    //Décoder la réponse JSON
    $data = json_decode($response, true);
    // Vérification des erreurs de décodage JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => json_last_error_msg()];
    }
    return $data;
}

function fetchApiCMC($url, $cmcApiKey): array
{
    // Initialisation de cURL
    $ch = curl_init();
    // Configuration des options de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-CMC_PRO_API_KEY: ' . $cmcApiKey,
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_CAINFO, "C:/myWAMP/php/extras/ssl/cacert.pem");

    // Exécution de la requête cURL
    $response = curl_exec($ch);
    // Vérification des erreurs cURL
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ["error" => $error_msg];
    }

    // Fermeture de cURL
    curl_close($ch);

    // Décoder la réponse JSON
    $data = json_decode($response, true);
    // Vérification des erreurs de décodage JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => json_last_error_msg()];
    }

    return $data;
}


function fetchApiCA($url, $coinapiKey): array
{
    // Initialisation de cURL
    $ch = curl_init();
    // Configuration des options de cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'X-CoinAPI-Key: ' . $coinapiKey,
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_CAINFO, "C:/myWAMP/php/extras/ssl/cacert.pem");

    // Exécution de la requête cURL
    $response = curl_exec($ch);
    // Vérification des erreurs cURL
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        curl_close($ch);
        return ["error" => $error_msg];
    }

    // Fermeture de cURL
    curl_close($ch);

    // Décoder la réponse JSON
    $data = json_decode($response, true);
    // Vérification des erreurs de décodage JSON
    if (json_last_error() !== JSON_ERROR_NONE) {
        return ['error' => json_last_error_msg()];
    }

    return $data;
}
