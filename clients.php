<?php
include 'include/nav.php';
require 'include/database.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
  <h2>Liste des catégories</h2>
  <a href="ajouter_categorie.php" class="btn btn-success mb-3">Ajouter une catégorie</a>
  <table class="table table-striped table-bordered">
    <thead class="table-dark"> <!-- En-tête en noir -->
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Date de création</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($categories as $categorie) { ?>
        <tr>
          <td><?= $categorie['id_categorie'] ?></td>
          <td><?= $categorie['nomcat'] ?></td>
          <td><?= $categorie['descriptioncat'] ?></td>
          <td><?= $categorie['date_creationcat'] ?></td>
          <td>
            <a href="modifier_categorie.php?id=<?= $categorie['id_categorie'] ?>" class="btn btn-warning btn-sm">Modifier</a>
            <a href="supprimer_categorie.php?id=<?= $categorie['id_categorie'] ?>" class="btn btn-danger btn-sm" 
               onclick="return confirm('Voulez-vous vraiment supprimer la catégorie <?= $categorie['nomcat'] ?> ?');">Supprimer</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
