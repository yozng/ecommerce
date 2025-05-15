<?php
include 'include/nav.php';
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header('Location: connexion.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Ajouter produit</title>
</head>
<body>
    <div class="container">
        <h4>Ajouter un produit</h4>
        <?php
        require 'include/database.php';
       if(isset($_POST['ajouter_produit'])){
            $nom = $_POST['nom'];
            $prix = $_POST['prix'];
            $promotion = $_POST['promotion'];
            $categorie = $_POST['categorie'];
            $description = $_POST['description'];
            $date = date('Y-m-d H:i:s');  
            $image_name = "produit.png";

            if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $image = $_FILES['image'];
                $image_name = uniqid() . "_" . ($image['name']);
                $upload_path = "upload/produit/" . $image_name;

                if (!move_uploaded_file($image['tmp_name'], $upload_path)) {
                    echo '<div class="alert alert-danger">Erreur lors de l\'upload de l\'image.</div>';
                    $image_name = "pardefaut.png"; 
                }
            } else {
                $image_name = "pardefaut.png";
            }



            if(!empty($nom) && !empty($prix) && !empty($categorie) && !empty($image_name)){ 
                $stmt = $pdo->prepare("INSERT INTO produits (nomp, prix, id_categorie,promo, description, image, date_creationp) VALUES (?,?,?,?,?,?,?)");
                $stmt->execute([$nom, $prix, $categorie, $promotion, $description, $image_name, $date]);
                if($stmt){
                    header('Location: produits.php');
                    exit;
                }else{
                    echo ' <div class="alert alert-danger" role="alert">
                        Erreur base de données !!
                    </div>';
                }
            }else{
                echo '<div class="alert alert-danger">Tous les champs obligatoires doivent être remplis.</div>';
            }
        }
        $stmt1 = $pdo->query("SELECT * FROM categorie");
        $categories = $stmt1->fetchAll(PDO::FETCH_ASSOC);
?>
    <form method="post" enctype="multipart/form-data">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required>

        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.1" name="prix" min='0' required>

        <label class="form-label">Promotion</label>
        <input type="range" class="form-control" name="promotion" value='0' min='0' max='90' >
        
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image" >

        <label class="form-label">Catégorie</label>
        <select name="categorie" class="form-select" required>
            <option value="">Sélectionner une catégorie</option>
            <?php foreach ($categories as $categorie) {
                echo "<option value='".$categorie['id_categorie']."'>".$categorie['nomcat']."</option>";
               }   ?>
        </select>

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" ></textarea>



        <input type="submit" name="ajouter_produit" value="Ajouter produit" class="btn btn-success my-2">

    </form>
    </div>
</body>
</html>