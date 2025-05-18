<?php
session_start();
require '../include/database.php';

if (!isset($_SESSION['utilisateur'])) {
    header('Location: ../connexion.php');
    exit;
}

$id = $_POST['id'];
$qty = $_POST['qty'];
$idUtilisateur = $_SESSION['utilisateur']['id_user'];

if (!isset($_SESSION['panier'][$idUtilisateur])) {
    $_SESSION['panier'][$idUtilisateur] = [];
}

if ($qty == 0) {
    unset($_SESSION['panier'][$idUtilisateur][$id]);
} else {
    $_SESSION['panier'][$idUtilisateur][$id] = $qty;
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
