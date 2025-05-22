<?php
session_start();
require_once '../include/database.php';

// Récupération des catégories
$stmt = $pdo->query("SELECT * FROM categorie");
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupération des filtres
$categorieId = isset($_GET['categorie_id']) ? (int)$_GET['categorie_id'] : 0;
$order = '';
if (isset($_GET['order']) && in_array(strtoupper($_GET['order']), ['ASC', 'DESC'])) {
    $order = strtoupper($_GET['order']);
}

// Récupération du terme de recherche
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Construction de la requête SQL
$query = "SELECT * FROM produits";
$params = [];
$conditions = [];

if ($categorieId > 0) {
    $conditions[] = "id_categorie = ?";
    $params[] = $categorieId;
}

if ($search !== '') {
    $conditions[] = "nomp LIKE ?";
    $params[] = "%$search%";
}

if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

if ($order !== '') {
    $query .= " ORDER BY prix $order";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction de calcul de remise
function calculerRemise($prix, $promo) {
    return round($prix * (1 - $promo / 100), 2);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <title>Liste des catégories et produits</title>
    <style>

  </style>
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div style="text-align: center; margin-top: 40px; margin-bottom: 10px;">
    <h1 style="font-size: 3.5rem; font-weight: 500;">Bienvenue sur JeuxDeSociété.ma</h1>
    <p style="font-size: 1.5rem; margin-top: 15px;">Votre boutique en ligne de jeux de société !</p>
</div>

<!-- Barre de recherche -->
<div class="container mb-4">
    <form method="get" class="d-flex justify-content-center" role="search">
        <input type="hidden" name="categorie_id" value="<?= $categorieId ?>">
        <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
        <input type="search" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control w-50 me-2" placeholder="Rechercher un produit par nom..." aria-label="Recherche" />
        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Rechercher</button>
    </form>
</div>

<div class="container py-4">
    <h4><i class="fa-solid fa-list-ul"></i> Filtrer par catégorie</h4>
    <div class="mb-3">
        <a href="client.php" class="btn btn-outline-primary me-2 <?= $categorieId === 0 ? 'active' : '' ?>">Tous</a>
        <?php foreach ($categories as $categorie): ?>
            <a href="client.php?categorie_id=<?= $categorie['id_categorie'] ?>" class="btn btn-outline-primary me-2 <?= $categorieId === (int)$categorie['id_categorie'] ? 'active' : '' ?>">
                <?= $categorie['nomcat'] ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Formulaire de tri -->
    <form method="get" class="mb-4 d-flex align-items-center gap-3">
        <input type="hidden" name="categorie_id" value="<?= $categorieId ?>">
        <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
        <label class="fw-semibold">Trier par prix :</label>
        <select name="order" class="form-select" style="width: 200px;" onchange="this.form.submit()">
            <option value="">Sans tri</option>
            <option value="ASC" <?= $order === 'ASC' ? 'selected' : '' ?>>Prix croissant</option>
            <option value="DESC" <?= $order === 'DESC' ? 'selected' : '' ?>>Prix décroissant</option>
        </select>
    </form>

    <h4><i class="fa-solid fa-box-open"></i> Liste des produits</h4>

    <div class="row">
        <?php if (count($produits) === 0): ?>
            <p>Aucun produit trouvé.</p>
        <?php else: ?>
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 position-relative">
                        <?php if (!empty($produit['promo'])): ?>
                            <span class="badge rounded-pill text-bg-warning w-25 position-absolute m-2" style="right:0">
                                - <?= $produit['promo'] ?>%
                            </span>
                        <?php endif; ?>

                        <?php if (!empty($produit['image'])): ?>
                            <img src="../upload/produit/<?= $produit['image'] ?>" alt="<?= $produit['nomp'] ?>" class="card-img-top w-75 mx-auto" style="height: 300px; object-fit: cover;" />
                        <?php endif; ?>

                        <div class="card-body">
                            <a href="produit.php?id=<?= $produit['id_produit'] ?>" class="btn stretched-link"></a>
                            <h5 class="card-title"><?= $produit['nomp'] ?></h5>
                            <p class="card-text"><?= $produit['description'] ?></p>
                            <p class="card-text">
                                <small class="text-muted">Ajouté le : <?= date_format(date_create($produit['date_creationp']), 'Y/m/d') ?></small>
                            </p>
                        </div>
                        <div class="card-footer bg-white text-center" style="z-index: 10;">
                            <?php if (!empty($produit['promo'])): ?>
                                <div class="h5">
                                    <span class="badge rounded-pill text-bg-danger">
                                        <strike><?= $produit['prix'] ?> MAD</strike>
                                    </span>
                                </div>
                                <div class="h5">
                                    <span class="badge rounded-pill text-bg-success">
                                        <?= calculerRemise($produit['prix'], $produit['promo']) ?> MAD
                                    </span>
                                </div>
                            <?php else: ?>
                                <div class="h5">
                                    <span class="badge rounded-pill text-bg-success">
                                        <?= $produit['prix'] ?> MAD
                                    </span>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="ajouter_panier.php" onsubmit="return checkLogin(event)">
                                <input type="hidden" name="id" value="<?= $produit['id_produit'] ?>" />
                                <input type="number" name="qty" value="1" min="1" max="99" class="form-control mb-2 mx-auto" style="width: 100px;" />
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
    const utilisateurConnecte = <?= isset($_SESSION['utilisateur']) ? 'true' : 'false' ?>;
    function checkLogin(event) {
        if (!utilisateurConnecte) {
            event.preventDefault();
            alert('Vous devez être connecté pour ajouter un produit au panier.');
            window.location.href = '../connexion.php';
            return false;
        }
        return true;
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>  