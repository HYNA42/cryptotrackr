<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
function getUserInformationFromSession()
{
    $date = new DateTime($_SESSION['birthday']);
    $birthday = $date->format('d-m-Y');

    return [

        'firstname' => $_SESSION['firstname'],
        'lastname' => $_SESSION['lastname'],
        'pseudo' => $_SESSION['pseudo'],
        'birthday' => $birthday,
        'email' => $_SESSION['email'],
        'id' => $_SESSION['id'],
        'default_picture' => $_SESSION['profil_picture']

    ];
}

// <img src="<?= (!empty($userInfos['default_picture'])) ? $userInfos['default_picture'] : IMG_URL . 'default.png'; ?>"
