<?php
session_start();
require '../include/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = $_POST['total'] ?? 0;
    $idUtilisateur = $_SESSION['utilisateur']['id_user'] ?? 0;

    $stmt = $pdo->prepare("INSERT INTO commandes (id_utilisateur, total, date_commande) VALUES (?, ?, NOW())");
    $stmt->execute([$idUtilisateur, $total]);

    unset($_SESSION['panier'][$idUtilisateur]);

    header("Location: confirmation_commande.php");
    exit();
} else {
    header("Location: panier.php");
    exit();
}
?>
