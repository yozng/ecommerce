<?php
    require_once 'include/database.php';
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM categorie WHERE id_categorie = ?");
        $supp = $stmt->execute([$id]);
        header('Location: categories.php');
        exit();
    }else {   
        echo "ID de catégorie non spécifié.";
    }

?>