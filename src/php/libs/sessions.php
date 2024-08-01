<?php
// require_once('required_files.php');
function init_session(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Commence la session si elle n'est pas déjà démarrée
        session_regenerate_id(true); // Regénère l'ID de session pour des raisons de sécurité
        return true; // Retourne true pour indiquer que la session a été initialisée avec succès
    }
    return false; // Retourne false si la session est déjà démarrée
}

function is_logged_session(): bool
{
    // session_start();
    return isset($_SESSION['id']);
}


function logout_session(): void
{
    session_unset();
    session_destroy();
    session_write_close();
}
