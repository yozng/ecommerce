<?php
session_start();
require '../include/database.php';

$idUtilisateur = $_SESSION['utilisateur']['id_user'] ?? 0;

$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id_clt = ?");
$stmt->execute([$idUtilisateur]);
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des Commandes</title>
</head>
<body>
    <h2>Historique de vos Commandes</h2>
    <table>
        <thead>
            <tr>
                <th>ID Commande</th>
                <th>Total</th>
                <th>Date de Création</th>
                <th>État</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?php echo $commande['id']; ?></td>
                    <td><?php echo $commande['total']; ?> MAD</td>
                    <td><?php echo $commande['date_creationc']; ?></td>
                    <td><?php echo $commande['valide'] ? 'Validée' : 'Non validée'; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
