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
    <?php include '../include/nav_front.php' ?>
    <div class="container py-2">
    <h4><?php echo $categorie1['nomcat'] ?></h4>
    <div class="container">
        <div class="row">
            <?php foreach ($produit as $produit1){ ?>
            <div class="card mb-3 col-md-4 m-1">
            <img src="../upload/produit/<?php echo $produit1['image'] ?>" class="card-img-top" alt="Card image cap" width="200" height="300">
            <div class="card-body">
                <a href="produit.php?id=<?php echo $produit1['id_produit'] ?>" class="btn stretched-link">Afficher détails</a>
                <h5 class="card-title"><?php echo $produit1['nomp'] ?></h5>
                <p class="card-text"><?php echo $produit1['description'] ?></p>
                <p class="card-text"><?php echo $produit1['prix'] ?> MAD</p>
                <p class="card-text">
                    <small class="text-body-secondary">Last updated : <?php echo date_format(date_create($produit1['date_creationp']), 'Y/m/d'); ?>
                    </small>
                </p>
             </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
</body>
</html>
