<?php
session_start();
require '../include/database.php';

if (!isset($_SESSION['utilisateur'])) {
    header('Location: ../connexion.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $total = $_POST['total'] ?? 0;
    $idUtilisateur = $_SESSION['utilisateur']['id_user'];
    $modePaiement = $_POST['mode_paiement'] ?? 'livraison'; // Par défaut, paiement à la livraison

    // Insérer la commande sans spécifier l'ID
    $stmt = $pdo->prepare("INSERT INTO commandes (id_clt, total, date_creationc, mode_paiement) VALUES (?, ?, NOW(), ?)");
    $stmt->execute([$idUtilisateur, $total, $modePaiement]);

    // Vider le panier
    unset($_SESSION['panier'][$idUtilisateur]);

    header("Location: confirmation_commande.php");
    exit();
} else {
    header("Location: panier.php");
    exit();
}
?>
