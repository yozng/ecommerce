<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'include/database.php';
// Vérifie si l'utilisateur est connecté et est un admin
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$id_user = $_SESSION['utilisateur']['id_user'];

// Récupère les infos de l'utilisateur
$sql = "SELECT login, nom, prenom, date_creation, role FROM utilisateurs WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_user]);
$utilisateur = $stmt->fetch();

if (!$utilisateur) {
    echo "Profil administrateur introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Profil Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap');
    
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      min-height: 100vh;
      font-family: 'Montserrat', sans-serif;
      display: flex;
      flex-direction: column;
      color: #2c2f4a;
    }
    .navbar {
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      background-color: #3b3f72 !important;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 1.6rem;
      color: #f8f9fa !important;
      letter-spacing: 2px;
    }
    .profile-card {
      max-width: 700px;
      margin: 60px auto 40px auto;
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.25);
      padding: 40px 50px;
      transition: transform 0.3s ease;
    }
    .profile-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 18px 40px rgba(0,0,0,0.3);
    }
    h2 {
      text-align: center;
      color: #4a3f6e;
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
      background-color: #6a5acd;
      color: #fff;
      font-weight: 600;
      font-size: 1.1rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
    }
    td {
      background: #f3f4fb;
      font-weight: 500;
      font-size: 1rem;
      color: #4b4f6f;
    }
    .btn-group a {
      width: 48%;
      font-weight: 700;
      font-size: 1.1rem;
      border-radius: 12px;
      transition: background-color 0.3s ease, color 0.3s ease;
      box-shadow: 0 5px 15px rgba(106, 90, 205, 0.4);
    }
    .btn-primary {
      background-color: #6a5acd;
      border: none;
    }
    .btn-primary:hover {
      background-color: #5942c7;
      box-shadow: 0 8px 20px rgba(89, 66, 199, 0.7);
    }
    .btn-danger {
      background-color: #e85959;
      border: none;
      box-shadow: 0 5px 15px rgba(232, 89, 89, 0.4);
    }
    .btn-danger:hover {
      background-color: #c84646;
      box-shadow: 0 8px 20px rgba(200, 70, 70, 0.7);
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="admin.php">Admin JeuxDeSociété</a>
  </div>
</nav>

<div class="profile-card shadow">
  <h2>Profil Administrateur</h2>
  <table class="table table-bordered mb-4">
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

  <div class="d-flex justify-content-between btn-group">
    <a href="admin.php" class="btn btn-primary">Retour</a>
    <a href="deconnexion.php" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">Déconnexion</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
