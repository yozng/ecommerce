<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../include/database.php';
// Vérifier si utilisateur connecté et client
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'client') {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['utilisateur']['id_user'];

// Récupérer infos utilisateur depuis la table utilisateurs
$sql = "SELECT login, nom, prenom, date_creation, role FROM utilisateurs WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$utilisateur = $stmt->fetch();

if (!$utilisateur) {
    echo "Profil utilisateur introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Profil Client</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    body {
      background: #f8f9fa;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }
    nav.navbar {
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .profile-card {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.1);
      padding: 30px;
    }
    .profile-card h2 {
      margin-bottom: 30px;
      font-weight: 700;
      color: #343a40;
      text-align: center;
    }
    table.table {
      margin-bottom: 30px;
    }
    table.table th {
      width: 35%;
      background-color: #343a40;
      color: white;
      font-weight: 600;
    }
    table.table td {
      font-weight: 500;
      color: #495057;
    }
    .btn-secondary {
      display: block;
      width: 100%;
      font-weight: 600;
      padding: 10px;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
      background-color: #23272b;
      color: white;
    }
    .btn {
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.3s ease;
    }
    .btn-retour {
     font-size: 1.2rem;
    }


  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="client.php">JeuxDeSociété</a>
  </div>
</nav>

<div class="profile-card shadow-sm">
  <h2>Mon profil</h2>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <th>Login</th>
        <td><?= $utilisateur['login']?></td>
      </tr>
      <tr>
        <th>Nom</th>
        <td><?= $utilisateur['nom'] ?></td>
      </tr>
      <tr>
        <th>Prénom</th>
        <td><?= $utilisateur['prenom'] ?></td>
      </tr>
      <tr>
        <th>Date de création</th>
        <td><?= $utilisateur['date_creation'] ?></td>
      </tr>
      <tr>
        <th>Rôle</th>
        <td><?= $utilisateur['role'] ?></td>
      </tr>
    </tbody>
  </table>

  <div class="d-flex justify-content-center gap-3 mt-4">
  <a href="client.php" class="btn btn-secondary px-4 btn-retour">Retour</a>
  <a href="historique_commande.php" class="btn btn-primary px-4">Historique des commandes</a>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
