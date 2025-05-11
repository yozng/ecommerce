<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Liste des produits</title>
</head>
<body>
    <?php include 'include/nav.php' ?>
    <div class="container">
        <h2>Liste des produits</h2>
        <a href="ajouter_categorie.php" class="btn btn-success">Ajouter une catégorie</a>
        <?php
            require 'include/database.php';
            if(!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
                header('Location: connexion.php');
                exit;
            }
            $produits = $pdo->query("SELECT produits.*,categorie.nomcat as 'nom_categorie' FROM produits INNER JOIN categorie ON produits.id_categorie = categorie.id_categorie")->fetchAll(PDO::FETCH_ASSOC);
            
         ?>
         <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Description</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Catégorie</th>
                    <th scope="col">Promotion</th>
                    <th scope="col">Date</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($produits as $produit){ ?>
                    <tr>
                        <td><?php echo $produit['id_produit'] ?></td>
                        <td><?php echo $produit['nomp'] ?></td>
                        <td><?php echo $produit['description'] ?></td>
                        <td><?php echo $produit['prix'] ?> MAD</td>
                        <td><?php echo $produit['nom_categorie'] ?></td>
                        <td><?php echo $produit['promo'] ?> %</td>
                        <td><?php echo $produit['date_creationp'] ?></td>
                        <td>
                            <a href="modifier_produit.php?id=<?php echo $produit['id_produit'] ?>" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="supprimer_produit.php?id=<?php echo $produit['id_produit'] ?>" class="btn btn-danger btn-sm" 
                            onclick="return confirm('Voulez-vous vraiment supprimer le produit <?php echo $produit['nomp'] ?>');" >Supprimer</a>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>