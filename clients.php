<?php
include 'include/database.php';
include 'include/nav.php';

$req = $pdo->query("SELECT id_user, login, nom, prenom, date_creation FROM utilisateurs WHERE role = 'client'");
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des clients</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
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
  <h2 class="mb-4">Liste des clients</h2> <!-- Espace ajouté ici -->
  <table class="table table-striped table-bordered align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>ID</th>
        <th>Login</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Date d'inscription</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($client = $req->fetch(PDO::FETCH_ASSOC)) { ?>
        <tr>
          <td><?= $client['id_user'] ?></td>
          <td><?= $client['login'] ?></td>
          <td><?= $client['nom'] ?></td>
          <td><?= $client['prenom'] ?></td>
          <td><?= $client['date_creation'] ?></td>
          <td>
            <a href="modifier_client.php?id=<?= $client['id_user'] ?>" class="btn btn-sm btn-warning">Modifier</a>
            <a href="supprimer_client.php?id=<?= $client['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">Supprimer</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

</body>
</html>
