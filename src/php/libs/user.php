<?php
require_once('pdo.php');

function issetParams(...$params): bool
{
    foreach ($params as $param) {
        if (isset($_POST[$param])) {
            return true;
        }
    }
    return false;
}

function verifyUserLoginAndPassword(string $email, string $password = null): bool | array
{

    $req = 'SELECT * FROM user WHERE email= :email';
    $stmt = Database::getInstance()->request($req, [$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC); //return false ou tableau

    if ($password) {
        //hasher le mot de passe (mdp de la bdd déjà haché)
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        } else {
            return false;
        }
    } else {
        return $user;
    }
}



//supprimer l'utilisateur de la bdd
function deleteUser(string $email): bool
{
    $req = 'DELETE FROM user WHERE email= :email';

    $stmt = Database::getInstance()->request($req, [$email]);

    //vérifier si la requete DELETE a bien fonctionné
    return $stmt->rowCount() > 0;
}

//verifie si le username est unique
function verifyUserPseudo($pseudo): bool
{
    $req = 'SELECT * FROM user WHERE pseudo= :pseudo';

    $stmt = Database::getInstance()->request($req, [$pseudo]);

    //vérifier si la requete DELETE a bien fonctionné
    return $stmt->rowCount() > 0;
}

//inscrire un utilisateur
function signupUser(string $firstname, string $lastname, string $pseudo, DateTime $birthday, string $email, $passwordHash): bool

{
    // Requête SQL avec des marqueurs de paramètres nommés
    $req = 'INSERT INTO user(id,firstname,lastname,pseudo,birthday,email,password)
    VALUES(UUID(),:firstname, :lastname, :pseudo, :birthday, :email, :password)';

    // Tableau associatif des paramètres
    $params = [
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':pseudo' => $pseudo,
        ':birthday' => $birthday->format('Y-m-d'), // Formatage de la date
        ':email' => $email,
        ':password' => $passwordHash
    ];

    // Exécution de la requête
    $stmt = Database::getInstance()->request($req, $params);

    return $stmt->rowCount() > 0;
}

//mise à jour des informations utilisateur
function updateUserInformations(string $id, string $firstname, string $lastname, string $pseudo, DateTime $birthday, $email, string $newPasswordHash = null): bool
{

    $req = 'UPDATE user SET firstname= :firstname,lastname= :lastname, pseudo= :pseudo, birthday= :birthday, email= :email';
    $params = [
        ':id' => $id,
        ':firstname' => $firstname,
        ':lastname' => $lastname,
        ':pseudo' => $pseudo,
        ':email' => $email,
        ':birthday' => $birthday->format('Y-m-d')

    ];

    if ($newPasswordHash) {
        $req .= ', password= :password';
        $params[':password'] = $newPasswordHash;
    }

    $req .= ' WHERE id= :id';
    $params[':id'] = $id;

    $stmt = Database::getInstance()->request($req, $params);

    // Retourner vrai si la requête s'exécute correctement, même si aucune ligne n'est modifiée
    return $stmt !== false;
}

//reset du password user
function resetUser(string $email, string $new_password_hash): bool
{
    $req = 'UPDATE user SET password = :new_password WHERE email = :email';

    $params = [
        ':new_password' => $new_password_hash,
        ':email' => $email,
    ];

    $stmt = Database::getInstance()->request($req, $params);

    return $stmt->rowCount() > 0;
}


//mettere à jour le chemin de la photo de profil
function updateProfilPicture($email, $newDirPicture)
{
    $req = 'UPDATE user SET profil_picture= :profil_picture WHERE email= :email';

    $params = [':profil_picture' => $newDirPicture, ':email' => $email];

    $stmt = Database::getInstance()->request($req, $params);
    return $stmt !== false;
}
