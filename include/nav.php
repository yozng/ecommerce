<?php
session_start();
$connecte = isset($_SESSION['utilisateur']);
$role = $connecte ? $_SESSION['utilisateur']['role'] : null;
$accueil = $connecte ? ($role === 'admin' ? 'admin.php' : 'front/client.php') : 'index.php';
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
    <a class="navbar-brand" href="<?php echo $accueil; ?>">JeuxDeSociété</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <ul class="navbar-nav ms-auto">
        <?php if (!$connecte) { ?>
          <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="inscription.php">Inscription</a></li>
          <li class="nav-item"><a class="nav-link" href="connexion.php">Connexion</a></li>
        <?php } elseif ($role === 'admin') { ?>
          <li class="nav-item"><a class="nav-link" href="categories.php">Les catégories</a></li>
          <li class="nav-item"><a class="nav-link" href="produits.php">Les produits</a></li>
          <li class="nav-item"><a class="nav-link" href="clients.php">Les Clients</a></li>
          <li class="nav-item"><a class="nav-link" href="deconnexion.php" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">Déconnexion</a></li>
        <?php } elseif ($role === 'client') { ?>
          <li class="nav-item"><a class="nav-link" href="categorie.php">Liste des catégories</a></li>
          <li class="nav-item"><a class="nav-link" href="deconnexion.php" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">Déconnexion</a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
</nav>

