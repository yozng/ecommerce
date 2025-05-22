<?php
session_start();
require '../include/database.php';

$idProduit = $_GET['id'] ?? 0;
$idUtilisateur = $_SESSION['utilisateur']['id_user'] ?? 0;

if (!isset($_SESSION['panier'][$idUtilisateur][$idProduit])) {
    die("Produit non trouvé dans le panier.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouvelleQuantite = (int)$_POST['quantite'];
    $_SESSION['panier'][$idUtilisateur][$idProduit] = max(1, $nouvelleQuantite);
    error_log("Quantité mise à jour pour produit ID $idProduit: $nouvelleQuantite");
    header("Location: panier.php");
    exit();
}
?>
