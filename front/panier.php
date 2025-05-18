<?php
session_start();
require '../include/database.php';

$idUtilisateur = $_SESSION['utilisateur']['id_user'] ?? 0;
$panier = $_SESSION['panier'][$idUtilisateur] ?? [];

if (!empty($panier)) {
    $idProduits = array_keys($panier);
    $idProduits = implode(',', $idProduits);
    $produits = $pdo->query("SELECT * FROM produits WHERE id_produit IN ($idProduits)")->fetchAll(PDO::FETCH_ASSOC);
} else {
    $produits = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Mon Panier</title>
</head>
<body>
    <?php include '../include/nav_front.php'; ?>
<div class="container mt-4">
    <h2>Mon Panier</h2>

    <div class="mb-3">
        <a href="client.php" class="btn btn-outline-primary">← Retour à la liste des produits</a>
    </div>

    <?php if (empty($produits)): ?>
        <div class="alert alert-warning">Votre panier est vide.</div>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Produit</th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Prix Unitaire</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalGeneral = 0;
                foreach ($produits as $produit):
                    $quantite = $panier[$produit['id_produit']];
                    $totalProduit = $produit['prix'] * $quantite;
                    $totalGeneral += $totalProduit;
                ?>
                    <tr>
                        <td><?php echo $produit['nomp']; ?></td>
                        <td><?php echo $quantite; ?></td>
                        <td><?php echo $produit['prix']; ?> MAD</td>
                        <td><?php echo $totalProduit; ?> MAD</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total Général</th>
                    <th><?php echo $totalGeneral; ?> MAD</th>
                </tr>
            </tfoot>
        </table>
        <div class="text-end">
            <a href="commander.php" class="btn btn-success">
                🧾 Valider la commande
            </a>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
