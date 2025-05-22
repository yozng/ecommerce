<?php
include 'include/nav.php';
require 'include/database.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}

$categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous" />
    <title>Liste des catégories</title>
    <style>
        body {
            background-color: #ffffff;
            color: #000;
        }
        td {
            background-color: #f0f0f0 !important;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h2>Liste des catégories</h2>
        <a href="ajouter_categorie.php" class="btn btn-success mb-3">Ajouter une catégorie</a>

        <table class="table table-striped table-hover table-bordered align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date</th>
                    <th scope="col">Opérations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $categorie) { ?>
                    <tr>
                        <td><?= $categorie['id_categorie'] ?></td>
                        <td><?= $categorie['nomcat'] ?></td>
                        <td><?= $categorie['descriptioncat'] ?></td>
                        <td><?= $categorie['date_creationcat'] ?></td>
                        <td>
                            <a href="modifier_categorie.php?id=<?= $categorie['id_categorie'] ?>" class="btn btn-primary btn-sm me-1">Modifier</a>
                            <a href="supprimer_categorie.php?id=<?= $categorie['id_categorie'] ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Voulez-vous vraiment supprimer la catégorie <?= $categorie['nomcat'] ?> ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
