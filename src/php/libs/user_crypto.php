<?php
require_once('pdo.php');
function verifyCryptoInfos(string $cryptoName)
{

    $sql = 'SELECT * FROM `Cryptocurrency` WHERE name = :name';
    $params = [':name' => $cryptoName];
    $crypto = Database::getInstance()->request($sql, $params)->fetch(PDO::FETCH_ASSOC);
    if ($crypto !== false) {
        return $crypto;
    }
}


function isCryptoFavorite(string $cryptoId, string $userId): bool
{
    $req = 'SELECT * FROM preference WHERE user_id=:user_id AND cryptocurrency_id=:cryptocurrency_id';
    $params = [
        ':user_id' => $userId,
        ':cryptocurrency_id' => $cryptoId
    ];
    $stmt = Database::getInstance()->request($req, $params)->fetch(PDO::FETCH_ASSOC);

    return $stmt !== false;
}

function deleteUserCryptoFavorite(string $cryptoId = null, string $userId): bool
{
    // Vérifier si l'ID de la crypto est fourni
    if ($cryptoId) {
        $req = 'DELETE FROM preference WHERE user_id=:user_id AND cryptocurrency_id=:cryptocurrency_id';
        $params = [
            ':user_id' => $userId,
            ':cryptocurrency_id' => $cryptoId
        ];
    } else {
        // Supprimer tous les favoris si l'ID de la crypto n'est pas fourni
        $req = 'DELETE FROM preference WHERE user_id=:user_id';
        $params = [
            ':user_id' => $userId
        ];
    }

    $stmt = Database::getInstance()->request($req, $params);

    return $stmt->rowCount() > 0;
}



function addUserCryptoFavorite(string $cryptoId, string $userId): bool
{
    $req = 'INSERT INTO preference(user_id,cryptocurrency_id)VALUES(:user_id,:cryptocurrency_id)';
    $params = [
        ':user_id' => $userId,
        ':cryptocurrency_id' => $cryptoId
    ];
    $stmt = Database::getInstance()->request($req, $params);

    return $stmt->rowCount() > 0;
}


function getUserFavorites(string $userId): array|bool
{
    $req = 'SELECT * FROM preference WHERE user_id=:user_id';

    $params = [
        ':user_id' => $userId
    ];

    $stmt = Database::getInstance()->request($req, $params)->fetchAll(PDO::FETCH_ASSOC);

    if ($stmt !== false) {
        return array_column($stmt, 'cryptocurrency_id');
    }

    return false;
}


function getCryptoById(string $cryptoId): bool|array
{
    $req = 'SELECT * FROM cryptocurrency WHERE id=:id';
    $params = [
        ':id' => $cryptoId
    ];

    $stmt = Database::getInstance()->request($req, $params)->fetch(PDO::FETCH_ASSOC);

    if ($stmt !== false) {
        return $stmt;
    }
    return false;
}


