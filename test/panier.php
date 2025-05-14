<?php
session_start();
require 'include/database.php';

$panier = $_SESSION['panier'] ?? [];

$produits = [];
$total = 0;

if (!empty($panier)) {
    $ids = array_keys($panier);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit IN ($placeholders)");
    $stmt->execute($ids);
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Votre Panier</h2>
        <?php if (empty($produits)): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix Unitaire</th>
                        <th>Quantité</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits as $produit): 
                        $id = $produit['id_produit'];
                        $quantite = $panier[$id];
                        $totalProduit = $produit['prix'] * $quantite;
                        $total += $totalProduit;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($produit['nomp']) ?></td>
                        <td><?= number_format($produit['prix'], 2) ?> MAD</td>
                        <td>
                            <form action="modifier_panier.php" method="post" class="d-flex">
                                <input type="hidden" name="id_produit" value="<?= $id ?>">
                                <input type="number" name="quantite" value="<?= $quantite ?>" min="1" class="form-control me-2" style="width: 80px;">
                                <button type="submit" class="btn btn-primary btn-sm">Mettre à jour</button>
                            </form>
                        </td>
                        <td><?= number_format($totalProduit, 2) ?> MAD</td>
                        <td>
                            <a href="supprimer_panier.php?id=<?= $id ?>" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total Général :</strong></td>
                        <td colspan="2"><strong><?= number_format($total, 2) ?> MAD</strong></td>
                    </tr>
                </tbody>
            </table>
            <a href="valider_commande.php" class="btn btn-success">Valider la commande</a>
        <?php endif; ?>
    </div>
</body>
</html>
