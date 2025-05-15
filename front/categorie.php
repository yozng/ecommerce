<?php

require_once '../include/database.php';

$categorie_id = $_GET['id'] ?? null;

if (!$categorie_id) {
    die("ID de catégorie invalide");
}

// Récupérer la catégorie (optionnel)
$stmtCat = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = ?");
$stmtCat->execute([$categorie_id]);
$categorie = $stmtCat->fetch(PDO::FETCH_ASSOC);
if (!$categorie) {
    die("Catégorie non trouvée");
}

// Récupérer les produits de cette catégorie
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id_categorie = ?");
$stmt->execute([$categorie_id]);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Produits de la catégorie <?= htmlspecialchars($categorie['nomcat']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container py-4">
  <h2>Produits dans la catégorie : <?= htmlspecialchars($categorie['nomcat']) ?></h2>

  <?php if (empty($produits)): ?>
    <p>Aucun produit dans cette catégorie.</p>
  <?php else: ?>
    <div class="row">
      <?php foreach ($produits as $produit): ?>
        <div class="col-md-4 mb-3">
          <div class="card">
            <!-- Image si tu en as -->
            <!-- <img src="..." class="card-img-top" alt="<?= htmlspecialchars($produit['nomp']) ?>"> -->
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($produit['nomp']) ?></h5>
              <p class="card-text"><?= number_format($produit['prix'], 2) ?> MAD</p>

              <form action="../front/ajouter_panier.php" method="post">
                <input type="hidden" name="id_produit" value="<?= $produit['id_produit'] ?>">
                <input type="number" name="quantite" value="1" min="1" class="form-control mb-2" style="width: 80px;">
                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
