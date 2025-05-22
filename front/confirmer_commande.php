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

    // Insérer la commande
    $stmt = $pdo->prepare("INSERT INTO commandes (id_clt, statut, total, mode_paiement) VALUES (?, 0, ?, ?)");
    $stmt->execute([$idUtilisateur, $total, $modePaiement]);
    $idCommande = $pdo->lastInsertId();

    // Insérer les lignes de commande
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

    // Vider le panier
    $_SESSION['panier'][$idUtilisateur] = [];

    header('Location: historique_commandes.php');
    exit;
}

header('Location: panier.php');
exit;
?>
