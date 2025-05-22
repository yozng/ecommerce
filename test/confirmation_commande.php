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
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de Commande</title>
</head>
<body>
    <?php include '../include/nav_front.php'; ?>
    <div class="container py-2">
        <h2>Confirmation de votre Commande</h2>
        <p>Total de la commande : <?= $total ?> MAD</p>
        
        <h3>Choisissez votre moyen de paiement :</h3>
        <form method="post" action="valider_commande.php">
            <input type="hidden" name="total" value="<?= $total ?>">
            <label>
                <input type="radio" name="mode_paiement" value="livraison" required> Paiement à la livraison
            </label><br>
            <label>
                <input type="radio" name="mode_paiement" value="carte" required> Paiement par carte bancaire
            </label><br>
            <button type="submit" class="btn btn-success">Confirmer la commande</button>
        </form>
        <a href="panier.php" class="btn btn-danger">Annuler la commande</a>
    </div>
</body>
</html>
