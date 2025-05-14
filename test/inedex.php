<?php
include 'include/nav.php';
require 'include/database.php';

$categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);

$whereClauses = [];
$params = [];

if (!empty($_GET['q'])) {
    $whereClauses[] = "nomp LIKE ?";
    $params[] = '%' . $_GET['q'] . '%';
}

if (!empty($_GET['categorie'])) {
    $whereClauses[] = "id_categorie = ?";
    $params[] = $_GET['categorie'];
}

if (!empty($_GET['min'])) {
    $whereClauses[] = "prix >= ?";
    $params[] = $_GET['min'];
}

if (!empty($_GET['max'])) {
    $whereClauses[] = "prix <= ?";
    $params[] = $_GET['max'];
}

$sql = "SELECT * FROM produits";
if ($whereClauses) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}
$sql .= " ORDER BY date_creationp DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
    <h2>Nos jeux</h2>
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="q" class="form-control" placeholder="Rechercher un jeu" value="<?php echo $_GET['q'] ?? ''; ?>">
        </div>
        <div class="col-md-3">
            <select name="categorie" class="form-select">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id_categorie']; ?>" <?php if (isset($_GET['categorie']) && $_GET['categorie'] == $cat['id_categorie']) echo 'selected'; ?>>
                        <?php echo $cat['nomcat']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="min" class="form-control" placeholder="Prix min" value="<?php echo $_GET['min'] ?? ''; ?>">
        </div>
        <div class="col-md-2">
            <input type="number" name="max" class="form-control" placeholder="Prix max" value="<?php echo $_GET['max'] ?? ''; ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </form>

    <div class="row">
        <?php if ($produits): ?>
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="images/<?php echo $produit['image']; ?>" class="card-img-top" alt="<?php echo $produit['nomp']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $produit['nomp']; ?></h5>
                            <p class="card-text"><?php echo $produit['prix']; ?> DH</p>
                            <a href="details.php?id=<?php echo $produit['id_produit']; ?>" class="btn btn-primary btn-sm">Voir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit trouvé.</p>
        <?php endif; ?>
    </div>
</div>
