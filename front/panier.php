<?php
session_start();
require '../include/database.php';

$idUtilisateur = $_SESSION['utilisateur']['id_user'] ?? 0;
$panier = $_SESSION['panier'][$idUtilisateur] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_single'])) {
    $idProduit = (int) ($_POST['id_produit'] ?? 0);
    $quantite = (int) ($_POST['quantite'] ?? 1);
    if ($quantite < 1) $quantite = 1;

    if (isset($panier[$idProduit])) {
        $panier[$idProduit] = $quantite;
        $_SESSION['panier'][$idUtilisateur] = $panier;
    }

    header('Location: panier.php');
    exit;
}

if (isset($_POST['vider'])) {
    $_SESSION['panier'][$idUtilisateur] = [];
    header('Location: panier.php');
    exit;
}

if (!empty($panier)) {
    $ids = array_keys($panier);
    $idsStr = implode(',', $ids);
    $produits = $pdo->query("SELECT * FROM produits WHERE id_produit IN ($idsStr)")->fetchAll(PDO::FETCH_ASSOC);
} else {
    $produits = [];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>Mon Panier</title>
    <style>
        /* Pour aligner la colonne Action à l’extrême droite */
        .table td.actions {
            white-space: nowrap;
            text-align: right;
            width: 1%;
        }
    </style>
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
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th style="width:110px;">Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                    <th class="actions">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $total = 0;
            foreach ($produits as $produit):
                $id = $produit['id_produit'];
                $quantite = $panier[$id];
                $totalProduit = $produit['prix'] * $quantite;
                $total += $totalProduit;
            ?>
                <tr>
                    <td><?= htmlspecialchars($produit['nomp']) ?></td>
                    <td>
                        <form method="post" class="d-flex align-items-center gap-2 mb-0">
                            <input type="hidden" name="id_produit" value="<?= $id ?>">
                            <input type="number" name="quantite" value="<?= $quantite ?>" min="1" class="form-control form-control-sm" style="width:70px;">
                    </td>
                    <td><?= $produit['prix'] ?> MAD</td>
                    <td><?= $totalProduit ?> MAD</td>
                    <td class="actions">
                            <button type="submit" name="update_single" class="btn btn-sm btn-primary me-2">Mettre à jour</button>
                        </form>
                        <a href="supprimer_panier.php?id=<?= $id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total Général</th>
                    <th colspan="2" class="text-start fw-bold"><?= $total ?> MAD</th>
                </tr>
            </tfoot>
        </table>

        <form method="post" action="valider_commande.php">
            <input type="hidden" name="total" value="<?= $total ?>">
            <button type="submit" class="btn btn-success">Valider la commande</button>
        </form>

        <form method="post" class="mt-3">
            <input onclick="return confirm('Voulez-vous vraiment vider le panier ?')" type="submit"
                   class="btn btn-danger" name="vider" value="Vider le panier">
        </form>
    <?php endif; ?>
</div>

</body>
</html>
