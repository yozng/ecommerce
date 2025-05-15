<?php
//session_start();
$productCount = array_sum($_SESSION['panier'] ?? []);
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="../connexion.php">Ecommerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link" href="client.php">Liste des catégories</a>
        <a class="nav-link" href="../front/panier.php">🛒 Panier (<?= $productCount ?>)</a>
        <a class="nav-link" href="connexion.php">Connexion</a>
      </div>
    </div>
  </div>
</nav>
<div class="container mt-4">
  <h1 class="text-center">Bienvenue sur JeuxDeSociété.ma</h1>
  <p class="text-center">Votre boutique en ligne de jeux de société !</p>
</div>