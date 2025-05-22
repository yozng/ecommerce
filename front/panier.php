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

// Fonction pour formater les prix
function formatPrix($prix) {
    return number_format($prix, 2, ',', ' ') . " MAD";
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
        .table td.actions {
            white-space: nowrap;
            text-align: right;
            width: 1%;
        }
        /* Pour bouton supprimer aligné verticalement */
        td.actions .btn-danger {
            margin-top: 0.2rem;
        }
    </style>
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container my-5">
    <h2 class="mb-4">Mon Panier</h2>
    <div class="mb-4">
        <a href="client.php" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour à la liste des produits
        </a>
    </div>

    <?php if (empty($produits)): ?>
        <div class="alert alert-warning fs-5" role="alert">
            Votre panier est vide.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produit</th>
                        <th style="width:120px;">Quantité</th>
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
                                <input type="number" name="quantite" value="<?= $quantite ?>" min="1" class="form-control form-control-sm" style="width:75px;">
                                <button type="submit" name="update_single" class="btn btn-sm btn-primary" title="Mettre à jour la quantité">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>
                        </td>
                        <td><?= formatPrix($produit['prix']) ?></td>
                        <td class="fw-semibold"><?= formatPrix($totalProduit) ?></td>
                        <td class="actions">
                            <a href="supprimer_panier.php?id=<?= $id ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Voulez-vous vraiment supprimer ce produit ?');" title="Supprimer ce produit">
                               <i class="bi bi-trash"></i> Supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="table-secondary fw-bold fs-5">
                        <td colspan="3" class="text-end">Total Général</td>
                        <td colspan="2"><?= formatPrix($total) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mt-4">
            <form method="post" onsubmit="return confirm('Voulez-vous vraiment vider le panier ?');">
                <button type="submit" name="vider" class="btn btn-outline-danger btn-lg">
                    <i class="bi bi-trash"></i> Vider le panier
                </button>
            </form>

            <form method="post" action="valider_commande.php">
                <input type="hidden" name="total" value="<?= $total ?>">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle"></i> Valider la commande
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
