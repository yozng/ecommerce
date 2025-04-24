<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Ajouter produit</title>
</head>
<body>
    <?php 
    include 'include/database.php';
    include 'include/nav.php' ?>
    <div class="container">
        <h4>Ajouter une produit</h4>
        <?php
        require 'include/database.php';
       if(isset($_POST['ajouter_produit'])){
            $nom = $_POST['nom'];
            $prix = $_POST['prix'];
            $promotion = $_POST['promotion'];
            $categorie = $_POST['categorie'];
            $description = $_POST['description'];
            $date = date('Y-m-d H:i:s');  

            //echo "$nom et $prix et $promotion et $categorie $description $date";

            if(!empty($nom) && !empty($prix) && !empty($categorie)){ 
                $stmt=$pdo->prepare("INSERT INTO produits (nomp, prix, id_categorie, description) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $prix, $categorie, $description]);
                if($stmt){
                ?>
                    <div class="alert alert-success" role="alert">
                        La produit <?php echo $nom ?> est ajoutée avec succès !
                    </div>
            <?php 
                }else{
            ?>
                    <div class="alert alert-danger" role="alert">
                        Erreur base de données !!
                    </div>
            <?php 
                }
            }else{
            ?>
                    <div class="alert alert-danger" role="alert">
                        Nom, prix et catégorie sont obligatoires ! 
                    </div>
            <?php 
                        
                }
    }
            ?>
    <form method="post">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required>

        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.1" name="prix" min='0' required>

        <label class="form-label">Promotion</label>
        <input type="range" class="form-control" name="promotion" value='0' min='0' max='90' required>

        <?php
        $stmt = $pdo->query("SELECT * FROM categorie");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>

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