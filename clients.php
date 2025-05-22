<?php
include 'include/database.php';
include 'include/nav.php';

$req = $pdo->query("SELECT id_user, login, nom, prenom, date_creation FROM utilisateurs WHERE role = 'client'");
?>

<div class="container mt-4">
  <h2>Liste des clients</h2>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
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
          <td><?= htmlspecialchars($client['id_user']) ?></td>
          <td><?= htmlspecialchars($client['login']) ?></td>
          <td><?= htmlspecialchars($client['nom']) ?></td>
          <td><?= htmlspecialchars($client['prenom']) ?></td>
          <td><?= htmlspecialchars($client['date_creation']) ?></td>
          <td>
            <a href="modifier_client.php?id=<?= $client['id_user'] ?>" class="btn btn-sm btn-warning">Modifier</a>
            <a href="supprimer_client.php?id=<?= $client['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?');">Supprimer</a>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>