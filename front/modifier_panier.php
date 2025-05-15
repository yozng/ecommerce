<?php
//session_start();
$idProduit = $_GET['id'] ?? 0;
$idUtilisateur = $_SESSION['utilisateur']['id'] ?? 0;

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
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Quantité</title>
</head>
<body>
    <form method="post">
        <label>Nouvelle quantité :</label>
        <input type="number" name="quantite" value="<?= $_SESSION['panier'][$idUtilisateur][$idProduit] ?>" min="1">
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
