<?php 
session_start();
include 'include/nav.php';
require 'include/database.php';

$message = '';

if (isset($_POST['connexion'])) {
    $login = $_POST['login'];
    $pwd = $_POST['password'];

    if (!empty($login) && !empty($pwd)) {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE login=? AND password=?");
        $stmt->execute([$login, $pwd]);

        if ($stmt->rowCount() >= 1) {
            $_SESSION['utilisateur'] = $stmt->fetch();

            if ($_SESSION['utilisateur']['role'] === 'admin') {
                header('Location: admin.php');
                exit;
            } elseif ($_SESSION['utilisateur']['role'] === 'client') {
                header('Location: front/client.php');
                exit;
            }
        } else {
            $message = '<div class="alert alert-danger text-center mt-3">Login ou mot de passe incorrect.</div>';
        }
    } else {
        $message = '<div class="alert alert-warning text-center mt-3">Tous les champs sont obligatoires.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: linear-gradient(135deg, #6a11cb, #2575fc);
      padding-top: 80px; /* Espace pour la navbar fixe */
      font-family: 'Segoe UI', sans-serif;
    }

    .login-card {
      background: #fff;
      border-radius: 16px;
      padding: 40px 30px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
      width: 100%;
      max-width: 420px;
      margin: 0 auto;
      margin-top: 60px;
    }

    .login-card h4 {
      font-weight: 700;
      color: #343a40;
      text-align: center;
      margin-bottom: 30px;
    }

    .form-label {
      font-weight: 600;
      color: #495057;
    }

    .btn-primary {
      background-color: #2575fc;
      border: none;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #1a5fd3;
    }
  </style>
</head>
<body>

<div class="login-card">
  <h4>Connexion à votre compte</h4>

  <?= $message ?>

  <form method="post">
    <div class="mb-3">
      <label class="form-label">Login</label>
      <input type="text" class="form-control" name="login" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Mot de passe</label>
      <input type="password" class="form-control" name="password" required>
    </div>

    <button type="submit" name="connexion" class="btn btn-primary w-100">Connexion</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
