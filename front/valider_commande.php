<?php
session_start();
require '../include/database.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'client') {
    header('Location: login.php');
    exit;
}

$idUtilisateur = $_SESSION['utilisateur']['id_user'];
$panier = $_SESSION['panier'][$idUtilisateur] ?? [];

if (empty($panier)) {
    header('Location: panier.php');
    exit;
}

// Calcul du total
$total = 0;
foreach ($panier as $idProduit => $quantite) {
    $stmt = $pdo->prepare("SELECT prix FROM produits WHERE id_produit = ?");
    $stmt->execute([$idProduit]);
    $produit = $stmt->fetch();
    if ($produit) {
        $total += $produit['prix'] * $quantite;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container mt-4">
    <h2>Choix du mode de paiement</h2>
    <form action="confirmer_commande.php" method="post">
        <input type="hidden" name="total" value="<?= $total ?>">

        <div class="mb-3">
            <label for="mode_paiement" class="form-label">Mode de paiement</label>
            <select name="mode_paiement" class="form-select" required>
                <option value="livraison">Paiement à la livraison</option>
                <option value="carte">Carte bancaire</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Confirmer la commande</button>
    </form>
</div>
</body>
</html>
