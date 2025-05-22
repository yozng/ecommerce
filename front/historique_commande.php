<?php
session_start();
require '../include/database.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'client') {
    header('Location: login.php');
    exit;
}

$idUtilisateur = $_SESSION['utilisateur']['id_user'];

$commandes = $pdo->prepare("SELECT * FROM commandes WHERE id_clt = ? ORDER BY date_creationc DESC");
$commandes->execute([$idUtilisateur]);
$liste = $commandes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container mt-4">
    <h2>Historique de mes commandes</h2>

    <?php if (empty($liste)): ?>
        <div class="alert alert-info">Vous n'avez passé aucune commande.</div>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Mode de paiement</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($liste as $commande): ?>
                    <tr>
                        <td><?= $commande['id_cmd'] ?></td>
                        <td><?= $commande['date_creationc'] ?></td>
                        <td><?= $commande['total'] ?> MAD</td>
                        <td><?= ucfirst($commande['mode_paiement']) ?></td>
                        <td>
                            <?= ($commande['statut'] == 0) ? "En attente" : "Validée" ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>
