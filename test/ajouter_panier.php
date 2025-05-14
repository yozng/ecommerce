<?php
session_start();
require 'include/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produit = intval($_POST['id_produit']);
    $quantite = intval($_POST['quantite']);

    // Vérifier si le produit existe
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit = ?");
    $stmt->execute([$id_produit]);
    $produit = $stmt->fetch();

    if ($produit) {
        // Initialiser le panier si nécessaire
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        // Ajouter ou mettre à jour la quantité du produit
        if (isset($_SESSION['panier'][$id_produit])) {
            $_SESSION['panier'][$id_produit] += $quantite;
        } else {
            $_SESSION['panier'][$id_produit] = $quantite;
        }

        header('Location: panier.php');
        exit;
    } else {
        echo "Produit non trouvé.";
    }
}
?>
