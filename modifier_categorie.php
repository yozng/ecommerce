<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Modifer catégorie</title>
</head>
<body>
    <?php include 'include/nav.php' ?>
    <div class="container">
        <h4>Modifier catégorie</h4>
        <?php
        require 'include/database.php';
        if (!isset($_GET['id'])) {
            echo '<div class="alert alert-danger">ID invalide</div>';
            exit;
        }

        $stmt=$pdo->prepare("SELECT * FROM categorie WHERE id_categorie=?");
        $stmt->execute([$_GET['id']]);
        $cat = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$cat) {
        echo '<div class="alert alert-danger">Catégorie introuvable</div>';
        exit;
        }

        if(isset($_POST['modifier-cat'])){
            $id = $_POST['id'];
            $nom = $_POST['nom'];
            $description = $_POST['description'];

            if(!empty($nom) && !empty($description)){
                $stmt=$pdo->prepare("UPDATE categorie SET nomcat=?, descriptioncat=? WHERE id_categorie=?");
                $stmt->execute([$nom, $description, $id]);
                header('Location: categories.php');
            }else{
                echo'<div class="alert alert-danger" role="alert">
                    Nom et description sont obligatoires ! 
                    </div>';
            }
        }
        ?>
    <form method="post">
        <input type="hidden" class="form-control" name="id" required value="<?php echo $cat['id_categorie'] ?>" readonly>
    
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required value="<?php echo $cat['nomcat'] ?>">

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" ><?php echo $cat['descriptioncat'] ?></textarea>

        <input type="submit" name="modifier-cat" value="Modifier catégorie" class="btn btn-success my-2">

    </form>
    </div>
</body>
</html>
