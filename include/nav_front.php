<?php
//session_start();

$connecte = isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'client';

$productCount = 0;
if (isset($_SESSION['panier']) && is_array($_SESSION['panier'])) {
    $idUtilisateur = $_SESSION['utilisateur']['id_user'] ?? 0;
    if (isset($_SESSION['panier'][$idUtilisateur]) && is_array($_SESSION['panier'][$idUtilisateur])) {
        // Calculez le nombre total de produits dans le panier
        $productCount = array_sum($_SESSION['panier'][$idUtilisateur]);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Jeux de Société</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="client.php">JeuxDeSociété</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="client.php">Liste des catégories</a></li>
        <li class="nav-item"><a class="nav-link" href="panier.php">🛒 Panier (<?= $productCount ?>)</a></li>
        <li class="nav-item"><a class="nav-link" href="../deconnexion.php" onclick="return confirm('Se déconnecter ?');">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h1 class="text-center">Bienvenue sur JeuxDeSociété.ma</h1>
  <p class="text-center">Votre boutique en ligne de jeux de société !</p>
</div>
