<?php
include 'include/nav.php';
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
   header('Location: connexion.php');
    exit;
}
require 'include/database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Modifier produit</title>
</head>
<body>
    <div class="container">
        <h4>Modifier un produit</h4>
        <?php
         if (!isset($_GET['id'])) { 
        echo '<div class="alert alert-danger">ID produit invalide</div>';
        exit;
    }

        $id = $_GET['id'];
        $stmt=$pdo->prepare("SELECT * FROM produits WHERE id_produit=?");
        $stmt->execute([$id]);
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produit) {
        echo '<div class="alert alert-danger">Produit introuvable</div>';
        exit;
    }

       if(isset($_POST['modifier_produit'])){
            $nom = $_POST['nom'];
            $prix = $_POST['prix'];
            $promotion = $_POST['promotion'];
            $categorie = $_POST['categorie'];
            $description = $_POST['description'];
            $image_name = "";

            if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = $_FILES['image'];
                $image_name = uniqid() . "_" . ($image['name']);
                $upload_path = "upload/produit/" . $image_name;
                move_uploaded_file($image['tmp_name'], $upload_path);
            }
            if (!empty($nom) && !empty($prix) && !empty($categorie)) {

            if (!empty($image_name)) {
                $stmt=$pdo->prepare("UPDATE produits SET nomp=?, prix=?, promo=?, id_categorie=?, description=?,image=? WHERE id_produit=?");
                $upd = $stmt->execute([$nom, $prix, $promotion, $categorie, $description, $image_name, $produit['id_produit']]);
            } else {
                $stmt=$pdo->prepare("UPDATE produits SET nomp=?, prix=?, promo=?, id_categorie=?, description=? WHERE id_produit=?");
                $upd=$stmt->execute([$nom, $prix, $promotion, $categorie, $description, $produit['id_produit']]);
            }

                if($upd){
                    header('Location: produits.php');
                    exit;
                }else{
                echo '<div class="alert alert-danger">Erreur base de données !</div>';
                }
            }else{
                echo '<div class="alert alert-danger">Nom, prix et catégorie sont obligatoires !</div>';
                }
    }
            ?>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="id" required value="<?php echo $produit['id_produit'] ?>" readonly>
    
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" value="<?php echo $produit['nomp'] ?>" >

        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.1" name="prix" min='0' value="<?php echo $produit['prix'] ?>" >

        <label class="form-label">Promotion</label>
        <input type="range" class="form-range" name="promotion" min="0" max="90" value="<?php echo $produit['promo']; ?>" required>

        <?php
        $stmt = $pdo->query("SELECT * FROM categorie");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <label class="form-label">Catégorie</label>
        <select name="categorie" class="form-select" required>
            <option value="">Sélectionner une catégorie</option>
            <?php foreach ($categories as $categorie) {
                if($categorie['id_categorie'] == $produit['id_categorie']){
                    echo "<option value='".$categorie['id_categorie']."' selected>".$categorie['nomcat']."</option>";
                }else{
                    echo "<option value='".$categorie['id_categorie']."'>".$categorie['nomcat']."</option>";
                }
               }   ?>
        </select>

        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image" >
        <img width="250" class="img img-fluid" src="upload/produit/<?php echo $produit['image']; ?>"><br>

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" ><?php echo $produit['description']; ?></textarea>

        <input type="submit" name="modifier_produit" value="Modifier produit" class="btn btn-success my-2">

    </form>
    </div>
</body>
</html>