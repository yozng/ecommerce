<?php
//session_start();
$idProduit = $_GET['id'] ?? 0;
$idUtilisateur = $_SESSION['utilisateur']['id'] ?? 0;

unset($_SESSION['panier'][$idUtilisateur][$idProduit]);
error_log("Produit ID $idProduit supprimé du panier utilisateur ID $idUtilisateur");

header("Location: panier.php");
exit(); 
?>
