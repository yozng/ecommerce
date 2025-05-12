<?php 
     require_once '../include/database.php';
        $stmt = $pdo->prepare("SELECT * FROM categorie WHERE id_categorie = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $categorie1 = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_categorie = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $produit = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <div class="container py-2">
    <h4><?php echo $categorie1['nomcat'] ?></h4>
    <div class="container">
        <div class="row">
            <?php foreach ($produit as $produit1){ ?>
            <div class="card mb-3 col-md-4">
            <img src="..." class="card-img-top" alt="..." width="200" height="300">
            <div class="card-body">
                <h5 class="card-title"><?php echo $produit1['nomp'] ?></h5>
                <p class="card-text"><?php echo $produit1['description'] ?></p>
                <p class="card-text">
                    <small class="text-body-secondary">Last updated : <?php echo date_format(date_create($produit1['date_creationp']), 'Y/m/d'); ?>
                    </small>
                </p>
             </div>
            </div>
            <?php } 
            if (empty($produit)) {
                ?><div class="alert alert-info" role="alert">
                    Aucun produit trouvé dans cette catégorie ! 
                  </div>
                 <?php
            }
            ?>
        </div>
    </div>
    </div>
  </div>
</div>
    </div>
</body>
</html>