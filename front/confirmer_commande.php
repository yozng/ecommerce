<?php
session_start();
require '../include/database.php';

if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'client') {
    header('Location: login.php');
    exit;
}

$idUtilisateur = $_SESSION['utilisateur']['id_user'];
$panier = $_SESSION['panier'][$idUtilisateur] ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($panier)) {
    $total = floatval($_POST['total']);
    $modePaiement = $_POST['mode_paiement'] ?? 'livraison';

    $stmt = $pdo->prepare("INSERT INTO commandes (id_clt, statut, total, mode_paiement) VALUES (?, 0, ?, ?)");
    $stmt->execute([$idUtilisateur, $total, $modePaiement]);
    $idCommande = $pdo->lastInsertId();

    foreach ($panier as $idProduit => $quantite) {
        $stmt = $pdo->prepare("SELECT prix FROM produits WHERE id_produit = ?");
        $stmt->execute([$idProduit]);
        $produit = $stmt->fetch();

        if ($produit) {
            $prix = $produit['prix'];
            $totalProduit = $prix * $quantite;

            $insert = $pdo->prepare("INSERT INTO lignesdecommandes (id_produit, id_cmd, quantite, prix, total) VALUES (?, ?, ?, ?, ?)");
            $insert->execute([$idProduit, $idCommande, $quantite, $prix, $totalProduit]);
        }
    }

    $_SESSION['panier'][$idUtilisateur] = [];

    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Commande confirmée</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script>
            // Redirection automatique après 5 secondes
            setTimeout(function () {
                window.location.href = 'client.php';
            }, 5000);
        </script>
    </head>
    <body>
    <div class="container mt-5">
        <div class="modal show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content border-success shadow">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">✅ Commande confirmée</h5>
                    </div>
                    <div class="modal-body">
                        <p>Votre commande a été enregistrée avec succès !</p>
                        <p>Merci pour votre achat 💚</p>
                        <p>Redirection vers la page principale dans <strong>5 secondes...</strong></p>
                    </div>
                    <div class="modal-footer">
                        <a href="client.php" class="btn btn-success">Aller à la page principale</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
    exit;
}

header('Location: panier.php');
exit;
