<?php 
require '../include/database.php';

$stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit = :id");
$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$produits = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupération de l'ID de catégorie pour le lien retour
$idCategorie = $produits['id_categorie'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit | <?php echo $produits['nomp']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container my-4">
    <!-- Bouton retour -->
    <a href="client.php" class="btn btn-outline-primary mb-3">← Retour à la liste des produits</a>

    <div class="row align-items-center">

        <div class="col-md-6 text-center">
            <img src="../upload/produit/<?php echo $produits['image']; ?>" 
                 class="img-fluid rounded shadow-sm border" 
                 alt="<?php echo $produits['nomp']; ?>" style="max-height: 400px;">
        </div>

        <div class="col-md-6">
            <h1 class="mb-3"><?php echo $produits['nomp']; ?></h1>

            <?php if (!empty($produits['promo'])): ?>
                <p><span class="badge bg-success fs-6">Promo : -<?php echo $produits['promo']; ?>%</span></p>
            <?php endif; ?>

            <?php
            $promo = $produits['promo'];
            $prix = $produits['prix'];
            if (!empty($promo)) {
                $total = $prix - (($prix * $promo) / 100);
                ?>
                <h4>
                    <span class="text-muted text-decoration-line-through"><?php echo $prix; ?> MAD</span>
                    <span class="text-danger fw-bold ms-2"><?php echo $total; ?> MAD</span>
                </h4>
            <?php } else { ?>
                <h4><span class="text-success fw-bold"><?php echo number_format($prix, 2); ?> MAD</span></h4>
            <?php } ?>

            <p class="mt-4"><?php echo $produits['description']; ?></p>

            <a href="ajouter_panier.php?id=<?php echo $produits['id_produit']; ?>" class="btn btn-primary btn-lg mt-3">
                Ajouter au panier
            </a>
        </div>
    </div>
</div>

</body>
</html>
