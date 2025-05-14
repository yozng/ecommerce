<?php
include 'include/nav.php';
require 'include/database.php';

// Récupération des filtres
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$marque = $_GET['marque'] ?? '';
$couleur = $_GET['couleur'] ?? '';
$age = $_GET['age'] ?? '';
$sort = $_GET['sort'] ?? '';

// Requête dynamique
$sql = "SELECT * FROM produits WHERE 1";
$params = [];

if ($search) {
    $sql .= " AND nomp LIKE ?";
    $params[] = "%$search%";
}
if ($category) {
    $sql .= " AND id_categorie = ?";
    $params[] = $category;
}
if ($marque) {
    $sql .= " AND description LIKE ?";
    $params[] = "%$marque%";
}
if ($couleur) {
    $sql .= " AND description LIKE ?";
    $params[] = "%$couleur%";
}
if ($age) {
    $sql .= " AND description LIKE ?";
    $params[] = "%$age%";
}
if ($sort === 'asc') {
    $sql .= " ORDER BY prix ASC";
} elseif ($sort === 'desc') {
    $sql .= " ORDER BY prix DESC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

$categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Recherche et Filtres</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-center">🔍 Rechercher un produit</h2>

  <form method="GET" class="row g-3 bg-light p-4 rounded shadow-sm mb-5">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Mot-clé..." value="<?= $search ?>">
    </div>
    <div class="col-md-2">
      <select name="category" class="form-select">
        <option value="">Catégorie</option>
        <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['id_categorie'] ?>" <?= $cat['id_categorie'] == $category ? 'selected' : '' ?>>
            <?= $cat['nomcat'] ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <input type="text" name="marque" class="form-control" placeholder="Marque..." value="<?= $marque ?>">
    </div>
    <div class="col-md-2">
      <input type="text" name="couleur" class="form-control" placeholder="Couleur..." value="<?= $couleur ?>">
    </div>
    <div class="col-md-2">
      <input type="text" name="age" class="form-control" placeholder="Âge recommandé..." value="<?= $age ?>">
    </div>

    <div class="col-md-3">
      <select name="sort" class="form-select">
        <option value="">Trier par prix</option>
        <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Prix croissant</option>
        <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Prix décroissant</option>
      </select>
    </div>

    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">Filtrer</button>
    </div>
  </form>

  <div class="row">
    <?php if (empty($produits)): ?>
      <p class="text-muted text-center">Aucun produit ne correspond à vos critères.</p>
    <?php else: ?>
      <?php foreach ($produits as $produit): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <img src="images/<?= $produit['image'] ?>" class="card-img-top" alt="<?= $produit['nomp'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $produit['nomp'] ?></h5>
              <p class="card-text"><?= $produit['prix'] ?> DH</p>
              <a href="details.php?id=<?= $produit['id_produit'] ?>" class="btn btn-sm btn-outline-primary">Voir</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
