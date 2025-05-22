<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #43cea2, #185a9d);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding-top: 70px; /* espace pour navbar fixe */
        }
        .inscription-card {
            background: #fff;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 480px;
        }
        .inscription-card h4 {
            font-weight: 700;
            color: #343a40;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-label {
            font-weight: 600;
            color: #495057;
        }
        .btn-success {
            background-color: #43cea2;
            border: none;
            font-weight: 600;
        }
        .btn-success:hover {
            background-color: #36b596;
        }
    </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="inscription-card">
    <h4>Créer un compte</h4>

    <?php
    if (isset($_POST['inscription'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $login = $_POST['login'];
        $password = $_POST['password'];

        if (!empty($nom) && !empty($prenom) && !empty($login) && !empty($password)) {
            require 'include/database.php';

            $checkUser = $pdo->prepare("SELECT * FROM utilisateurs WHERE login = ?");
            $checkUser->execute([$login]);

            if ($checkUser->rowCount() > 0) {
                echo '<div class="alert alert-warning text-center">Ce login est déjà utilisé.</div>';
            } else {
                $date = date('Y-m-d H:i:s');
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (login, password, nom, prenom, date_creation, role) VALUES (?, ?, ?, ?, ?, 'client')");
                $stmt->execute([$login, $password, $nom, $prenom, $date]);

                echo '<div class="alert alert-success text-center">Inscription réussie ! Redirection en cours...</div>';
                header("refresh:2;url=connexion.php"); // redirection après 2 secondes
                exit;
            }
        } else {
            echo '<div class="alert alert-danger text-center">Tous les champs sont obligatoires.</div>';
        }
    }
    ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" class="form-control" name="nom" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" class="form-control" name="prenom" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Login</label>
            <input type="text" class="form-control" name="login" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" name="inscription" class="btn btn-success w-100">S'inscrire</button>
    </form>
</div>

</body>
</html>
