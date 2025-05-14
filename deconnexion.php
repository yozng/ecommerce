<?php
session_start();

if (isset($_SESSION['utilisateur'])) {
    session_unset(); 
    session_destroy(); 
    header('Location: connexion.php'); 
    exit(); 
} else {
    header('Location: connexion.php');
    exit();
}
?>
