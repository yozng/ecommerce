<?php
    require_once 'include/database.php';
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM produits WHERE id_produit = ?");
        $supp = $stmt->execute([$id]);
        header('Location: produits.php');
        exit();
    }else {   
        echo "ID de produit non spécifié.";
    }

?>
