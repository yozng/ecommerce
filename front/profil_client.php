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
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');

    body {
      background: linear-gradient(135deg, #f6d365, #fda085); /* dégradé doux chaud */
      min-height: 100vh;
      font-family: 'Montserrat', sans-serif;
      display: flex;
      flex-direction: column;
      color: #5a3e36;
    }
    .navbar {
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      background-color: #b75d62 !important; /* bordeaux doux */
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 1.6rem;
      color: #fefefe !important;
      letter-spacing: 2px;
    }
    .profile-card {
      max-width: 700px;
      margin: 60px auto 40px auto;
      background: #fff3e6;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.2);
      padding: 40px 50px;
      transition: transform 0.3s ease;
    }
    .profile-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.3);
    }
    h2 {
      text-align: center;
      color: #b75d62;
      margin-bottom: 40px;
      font-weight: 700;
      letter-spacing: 1.2px;
      font-size: 2.4rem;
    }
    table.table {
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }
    th {
      background-color: #b75d62;
      color: #fff;
      font-weight: 600;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    td {
      background: #fff7f0;
      font-weight: 500;
      font-size: 1rem;
      color: #6f4e43;
    }
    .btn-group, .d-flex.justify-content-center.gap-3 {
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
    }
    .btn-secondary {
      background-color: #f6a07f;
      border: none;
      font-weight: 700;
      font-size: 1.1rem;
      border-radius: 12px;
      padding: 10px 40px;
      box-shadow: 0 5px 15px rgba(246, 160, 127, 0.5);
      color: #fff;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-secondary:hover {
      background-color: #d3745c;
      box-shadow: 0 8px 20px rgba(211, 116, 92, 0.7);
      color: #fff;
    }
    .btn-primary {
      background-color: #b75d62;
      border: none;
      font-weight: 700;
      font-size: 1.1rem;
      border-radius: 12px;
      padding: 10px 40px;
      box-shadow: 0 5px 15px rgba(183, 93, 98, 0.5);
      color: #fff;
      transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #913f45;
      box-shadow: 0 8px 20px rgba(145, 63, 69, 0.7);
      color: #fff;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
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
        <td><?= htmlspecialchars($utilisateur['login']) ?></td>
      </tr>
      <tr>
        <th>Nom</th>
        <td><?= htmlspecialchars($utilisateur['nom']) ?></td>
      </tr>
      <tr>
        <th>Prénom</th>
        <td><?= htmlspecialchars($utilisateur['prenom']) ?></td>
      </tr>
      <tr>
        <th>Date de création</th>
        <td><?= htmlspecialchars($utilisateur['date_creation']) ?></td>
      </tr>
      <tr>
        <th>Rôle</th>
        <td><?= htmlspecialchars($utilisateur['role']) ?></td>
      </tr>
    </tbody>
  </table>

  <div class="d-flex justify-content-center gap-3">
    <a href="client.php" class="btn btn-secondary">Retour</a>
    <a href="historique_commande.php" class="btn btn-primary">Historique des commandes</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
