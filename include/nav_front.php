<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$connecte = isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'client';

$productCount = 0;
$prenom = $nom = $login = '';

if ($connecte) {
    $utilisateur = $_SESSION['utilisateur'];
    $prenom = $utilisateur['prenom'] ?? '';
    $nom = $utilisateur['nom'] ?? '';
    $loging = $utilisateur['login'] ?? '';

    $idUtilisateur = $utilisateur['id_user'] ?? 0;
    if (isset($_SESSION['panier'][$idUtilisateur]) && is_array($_SESSION['panier'][$idUtilisateur])) {
        $productCount = array_sum($_SESSION['panier'][$idUtilisateur]);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Jeux de Société</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="client.php">JeuxDeSociété</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" 
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item"><a class="nav-link" href="client.php">Produits</a></li>
        <li class="nav-item"><a class="nav-link" href="panier.php">🛒 Panier (<?= $productCount ?>)</a></li>

        <?php if ($connecte): ?>
          <!-- Icône profil cliquable -->
          <li class="nav-item">
            <a class="nav-link" href="profil_client.php" title="Mon profil">
              <i class="bi bi-person-circle" style="font-size: 1.4rem;"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="../deconnexion.php" onclick="return confirm('Se déconnecter ?');">Déconnexion</a>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="../login.php">Connexion</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
