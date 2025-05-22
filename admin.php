<?php
session_start();
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            min-height: 100vh;
            padding-top: 80px; /* espace pour navbar */
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        .admin-card h2 {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
        }

        .admin-card p {
            font-size: 16px;
            color: #555;
        }

        .admin-icon {
            font-size: 50px;
            color: #3498db;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="admin-card">
    <div class="admin-icon">
        <i class="bi bi-person-gear"></i>
    </div>
    <h2>Bienvenue Admin, <?= htmlspecialchars($_SESSION['utilisateur']['prenom']) ?> !</h2>
    <p>Vous êtes connecté à l'espace d'administration.</p>
</div>

<!-- Icônes Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</body>
</html>
