<?php
  session_start();
  /*$connecte = false;
  if(isset($_SESSION['utilisateur'])) {
    $connecte = true;*/
  $connecte = isset($_SESSION['utilisateur']);
  $role = $connecte ? $_SESSION['utilisateur']['role'] : null;
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Ecommerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-link" href="#">Accueil</a>
        <?php if (!$connecte) { ?>
          <a class="nav-link" href="acceuil.php">Acceuil</a>
          <a class="nav-link" href="inscription.php">Inscription</a>
          <a class="nav-link" href="connexion.php">Connexion</a>
        <?php } else if ($role === 'admin') { ?>
          <a class="nav-link" href="admin.php">Acceuil</a>
          <a class="nav-link" href="#">Ajouter produit</a>
          <a class="nav-link" href="#">Supprimer produit</a>
          <a class="nav-link" href="#">Modifier produit</a>
          <a class="nav-link" href="#">Modifier Clients</a>
          <a class="nav-link" href="deconnexion.php">Déconnexion</a>
        <?php } else { ?>
          <a class="nav-link" href="client.php">Acceuil</a>
          <a class="nav-link" href="deconnexion.php">Déconnexion</a>
        <?php } ?>
    </div>
    </div>
  </div>
</nav>