<?php
  session_start();
  /*$connecte = false;
  if(isset($_SESSION['utilisateur'])) {
    $connecte = true;*/
  $connecte = isset($_SESSION['utilisateur']);
  $role = $connecte ? $_SESSION['utilisateur']['role'] : null;

  $accueil = $connecte ? ($role === 'admin' ? 'admin.php' : 'front/client.php') : 'acceuil.php';
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo $accueil; ?>">Ecommerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
        <?php if (!$connecte) { ?>
          <a class="nav-link" href="index.php">Accueil</a>
          <a class="nav-link" href="inscription.php">Inscription</a>
          <a class="nav-link" href="connexion.php">Connexion</a>
        <?php } else if ($role === 'admin') { ?>

          <a class="nav-link" href="categories">Les catégories</a>
          <a class="nav-link" href="produits">Les produits</a>
          <a class="nav-link" href="#">Les Clients</a>
          <a class="nav-link" href="deconnexion.php" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">Déconnexion</a>
        <?php } else if ($role === 'client'){ ?>
          <a class="nav-link" href="categorie.php">Liste des catégories</a>
          <a class="nav-link" href="deconnexion.php" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">Déconnexion</a>
        <?php } ?>
    </div>
    </div>
  </div>
</nav>