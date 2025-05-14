<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produit = intval($_POST['id_produit']);
    $quantite = intval($_POST['quantite']);

    if (isset($_SESSION['panier'][$id_produit])) {
        if ($quantite > 0) {
            $_SESSION['panier'][$id_produit] = $quantite;
        } else {
            unset($_SESSION['panier'][$id_produit]);
        }
    }
}

header('Location: panier.php');
exit;
?>
