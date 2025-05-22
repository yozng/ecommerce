<?php 
session_start();
require_once '../include/database.php';

// Récupération des catégories
$stmt = $pdo->query("SELECT * FROM categorie");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Tri par prix
$order = '';
if (isset($_GET['order']) && in_array(strtoupper($_GET['order']), ['ASC', 'DESC'])) {
    $order = strtoupper($_GET['order']);
}

// Produits
if ($order === '') {
    $stmt = $pdo->query("SELECT * FROM produits");
} else {
    $stmt = $pdo->prepare("SELECT * FROM produits ORDER BY prix $order");
    $stmt->execute();
}
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

function calculerRemise($prix, $promo) {
    return round($prix * (1 - $promo / 100), 2);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <title>Produits & Catégories</title>
</head>
<body>

<?php include '../include/nav_front.php'; ?>

<div style="text-align: center; margin-top: 40px; margin-bottom: 100px;">
    <h1 style="font-size: 3.5rem; font-weight: 500;">Bienvenue sur JeuxDeSociété.ma</h1>
    <p style="font-size: 1.5rem; margin-top: 15px;">Votre boutique en ligne de jeux de société !</p>
</div>

<div class="container-fluid my-4">
    <div style="display: flex; gap: 20px;">

        <!-- Catégories -->
        <div style="flex: 0 0 25%; border-right: 1px solid #ddd; padding-right: 15px;">
            <h5 style="text-align: center;"><i class="fa-solid fa-list-ul"></i> Catégories</h5>
            <ul class="list-group list-group-flush" style="max-width: 300px; margin: 0 auto;">
                <?php foreach ($categories as $categorie): ?>
                    <li class="list-group-item p-1">
                        <a class="btn btn-sm btn-light w-100 text-start" href="categorie.php?id=<?= $categorie['id_categorie']; ?>">
                            <?= $categorie['nomcat'] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Produits -->
        <div style="flex: 1; padding-left: 15px;">
            <h5 style="text-align: center; margin-bottom: 20px;"><i class="fa-solid fa-box-open"></i> Produits disponibles</h5>

            <!-- Tri -->
            <form method="get" style="text-align: center; margin-bottom: 20px;">
                <label for="order" class="me-2 fw-semibold">Trier par prix :</label>
                <select name="order" id="order" onchange="this.form.submit()" class="form-select d-inline-block" style="width: 200px;">
                    <option value="" <?= $order === '' ? 'selected' : '' ?>>Sans tri</option>
                    <option value="ASC" <?= $order === 'ASC' ? 'selected' : '' ?>>Prix croissant</option>
                    <option value="DESC" <?= $order === 'DESC' ? 'selected' : '' ?>>Prix décroissant</option>
                </select>
                <noscript><button type="submit" class="btn btn-primary ms-2">Trier</button></noscript>
            </form>

            <div class="row row-cols-2 gx-4 gy-4" style="margin: 0 15px;">
                <?php foreach ($produits as $produit): ?>
                    <div class="col">
                        <div class="card h-100 position-relative">
                            <?php if (!empty($produit['promo'])): ?>
                                <span class="badge rounded-pill text-bg-warning position-absolute m-2" style="right: 0;">
                                    -<?= (int)$produit['promo'] ?>%
                                </span>
                            <?php endif; ?>

                            <img src="../upload/produit/<?= $produit['image'] ?>" alt="<?= $produit['nomp'] ?>" 
                                 class="card-img-top" style="height: 220px; object-fit: cover;">

                            <div class="card-body">
                                <h5 class="card-title"><?= $produit['nomp'] ?></h5>
                                <p class="card-text"><?= $produit['description'] ?></p>
                            </div>

                            <div class="card-footer text-center bg-white">
                                <?php if (!empty($produit['promo'])): ?>
                                    <div class="text-muted text-decoration-line-through"><?= $produit['prix'] ?> MAD</div>
                                    <div class="text-danger fw-bold"><?= calculerRemise($produit['prix'], $produit['promo']) ?> MAD</div>
                                <?php else: ?>
                                    <div class="text-success fw-bold"><?= $produit['prix'] ?> MAD</div>
                                <?php endif; ?>

                                <div class="d-flex justify-content-center gap-2 mt-2">
                                    <a href="produit.php?id=<?= (int)$produit['id_produit'] ?>" class="btn btn-outline-secondary">
                                        Voir le produit
                                    </a>
                                    <form method="post" action="ajouter_panier.php">
                                        <input type="hidden" name="id" value="<?= (int)$produit['id_produit'] ?>">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-cart-plus"></i> Ajouter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
