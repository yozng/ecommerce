<?php
include 'include/nav.php';
require 'include/database.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}

$produits = $pdo->query("SELECT produits.*, categorie.nomcat as 'nom_categorie' FROM produits INNER JOIN categorie ON produits.id_categorie = categorie.id_categorie")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
  <h2>Liste des produits</h2>
  <a href="ajouter_produit.php" class="btn btn-success mb-3">Ajouter un produit</a>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Prix</th>
        <th>Catégorie</th>
        <th>Image</th>
        <th>Promotion</th>
        <th>Date de création</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($produits as $produit) { ?>
        <tr>
          <td><?= $produit['id_produit'] ?></td>
          <td><?= $produit['nomp'] ?></td>
          <td><?= $produit['description'] ?></td>
          <td><?= $produit['prix'] ?> MAD</td>
          <td><?= $produit['nom_categorie'] ?></td>
          <td>
            <img src="upload/produit/<?= $produit['image'] ?>" alt="<?= $produit['nomp'] ?>" style="max-width: 100px;" class="img-fluid" />
          </td>
          <td><?= $produit['promo'] ?> %</td>
          <td><?= $produit['date_creationp'] ?></td>
          <td>
            <a href="modifier_produit.php?id=<?= $produit['id_produit'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="supprimer_produit.php?id=<?= $produit['id_produit'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer le produit <?= $produit['nomp'] ?> ?');">Supprimer</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
