<?php 
session_start();
     require_once '../include/database.php';
     $idUtilisateur = isset($_SESSION['utilisateur']) ? $_SESSION['utilisateur']['id_user'] : 0;
    
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $categorie1 = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_categorie = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $produit = $stmt->fetchAll(PDO::FETCH_ASSOC);

        function calculerRemise($prix, $promo) {
          return round($prix * (1 - $promo / 100), 2);
        }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Categorie | <?php echo $categorie1['nomcat'] ?></title>
</head>
<body>
    <?php include '../include/nav_front.php' ?>
    <div class="container mt-3">
        <a href="client.php" class="btn btn-outline-primary">← Retour à la liste des catégories</a>
    </div>

    <div class="container py-2">
    <h4><?php echo $categorie1['nomcat'] ?></h4>
    <div class="container">
        <div class="row">
            <?php if (!empty($produit)){
              foreach ($produit as $produit1) {
              $idProduit = $produit1['id_produit'];?>
        <div class="col-md-4 mb-4">
           <div class="card h-100 position-relative">

            <?php if (!empty($produit1['promo'])): ?>
                <span class="badge rounded-pill text-bg-warning w-25 position-absolute m-2" style="right:0"> - <?= $produit1['promo'] ?>% </span>
            <?php endif; ?>

            <img class="card-img-top w-75 mx-auto" src="../upload/produit/<?= $produit1['image'] ?>"
                 alt="<?= $produit1['nomp'] ?>" style="height: 300px; object-fit: cover;">
            <div class="card-body">
                <a href="produit.php?id=<?= $idProduit ?>" class="btn stretched-link"></a>
                <h5 class="card-title"><?= $produit1['nomp'] ?></h5>
                <p class="card-text"><?= $produit1['description'] ?></p>
                <p class="card-text">
                    <small class="text-muted">Ajouté le :
                        <?= date_format(date_create($produit1['date_creationp']), 'Y/m/d') ?>
                    </small>
                </p>
            </div>
            <div class="card-footer bg-white text-center" style="z-index: 10">
                <?php if (!empty($produit1['promo'])){ ?>
                    <div class="h5">
                        <span class="badge rounded-pill text-bg-danger">
                            <strike><?= $produit1['prix'] ?> MAD</strike>
                        </span>
                    </div>
                    <div class="h5">
                        <span class="badge rounded-pill text-bg-success">
                            Solde : <?= calculerRemise($produit1['prix'], $produit1['promo']) ?> MAD
                        </span>
                    </div>
                <?php }else{ ?>
                    <div class="h5">
                        <span class="badge rounded-pill text-bg-success">
                            <?= $produit1['prix'] ?> MAD
                        </span>
                    </div>
                <?php } ?>
                        <form method="post" action="ajouter_panier.php" onsubmit="return checkLogin(event)">
                                <input type="hidden" name="id" value="<?= $produit1['id_produit']; ?>" />
                                <input type="number" name="qty" value="1" min="1" max="99" class="form-control mb-2 mx-auto" style="width: 100px; display: block;" />
                                <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                            </form> 
            </div>
        </div>
    </div>
    <?php }}
        else{ ?>
    <div class="alert alert-info" role="alert">
        Pas de produits pour l'instant
    </div>
    <?php } ?>
    <script>
        const utilisateurConnecte = <?php echo isset($_SESSION['utilisateur']) ? 'true' : 'false'; ?>;
        function checkLogin(event) {
        if (!utilisateurConnecte) {
         event.preventDefault();
         alert('Vous devez être connecté pour ajouter un produit au panier.');
         window.location.href = 'connexion.php';
         return false;
        }
    return true;
}
</script>
</body>
</html>