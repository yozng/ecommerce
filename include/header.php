<?php
session_start();
$isClient = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'client';
$isAdmin = isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Jeux de Société</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">JeuxDeSociété.ma</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">

        <li class="nav-item"><a class="nav-link" href="produits.php">Produits</a></li>

        <?php if ($isClient): ?>
          <li class="nav-item"><a class="nav-link" href="panier.php">Panier</a></li>
          <li class="nav-item"><a class="nav-link" href="deconnexion.php">Déconnexion</a></li>
        <?php elseif ($isAdmin): ?>
          <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="deconnexion.php">Déconnexion</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
  <h1 class="text-center">Bienvenue sur JeuxDeSociété.ma</h1>
  <p class="text-center">Votre boutique en ligne de jeux de société !</p>
</div>
