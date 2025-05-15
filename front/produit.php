<?php 
     require_once '../include/database.php';
        $stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        $produits = $stmt->fetch(PDO::FETCH_ASSOC);

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Produit | <?php echo $produits['nomp'] ?></title>
</head>
<body>
    <?php include '../include/nav_front.php' ?>
    <div class="container py-2">
    <h4><?php echo $produits['nomp'] ?></h4>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="../upload/produit/<?php echo $produits['image'] ?>" class="img img-fluid w-75" alt="<?php echo $produits['nomp'] ?>" width="200" height="300">
            </div>
            <div class="col-md-6">
                <H1><?php echo $produits['nomp'] ?></H1>
                <p><?php echo $produits['description'] ?></p>
                <p><?php echo $produits['prix'] ?> MAD</p>
            </div>
        </div>
    </div>
    </div>
  </div>
</div>
    </div>
</body>
</html> 