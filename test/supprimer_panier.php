<?php
session_start();

if (isset($_GET['id'])) {
    $id_produit = intval($_GET['id']);
    unset($_SESSION['panier'][$id_produit]);
}

header('Location: panier.php');
exit;
?>
