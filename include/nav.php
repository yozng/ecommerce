<?php
  session_start();
  /*$connecte = false;
  if(isset($_SESSION['utilisateur'])) {
    $connecte = true;*/
  $connecte = isset($_SESSION['utilisateur']);
  $role = $connecte ? $_SESSION['utilisateur']['role'] : null;

  if (!$connecte) {
    $accueil = 'acceuil.php';
  } else if ($role === 'admin') {
    $accueil = 'admin.php';
  } else {
    $accueil = 'client.php';
}
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
          <a class="nav-link" href="inscription.php">Inscription</a>
          <a class="nav-link" href="connexion.php">Connexion</a>
        <?php } else if ($role === 'admin') { ?>

          <a class="nav-link" href="categories">Liste des catégories</a>
          <a class="nav-link" href="produits">Liste des produits</a>
     <!--     <a class="nav-link" href="ajouter_categorie">Ajouter catégorie</a> -->
          <a class="nav-link" href="ajouter_produit">Ajouter produit</a>

          <a class="nav-link" href="supprimer_produit">Supprimer produit</a>
          <a class="nav-link" href="supprimer_categorie">Modifier produit</a>
          <a class="nav-link" href="#">Modifier Clients</a>
          <a class="nav-link" href="deconnexion.php">Déconnexion</a>
        <?php } else if ($role === 'client'){ ?>
          <a class="nav-link" href="deconnexion.php">Déconnexion</a>
        <?php } ?>
    </div>
    </div>
  </div>
</nav>