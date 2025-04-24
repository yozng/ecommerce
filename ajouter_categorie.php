<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Ajouter catégorie</title>
</head>
<body>
    <?php include 'include/nav.php' ?>
    <div class="container">
        <h4>Ajouter une catégorie</h4>
        <?php
       if(isset($_POST['ajouter_cat'])){
            $nom = $_POST['nom'];
            $description = $_POST['description'];

            if(!empty($nom) && !empty($description)){
                require 'include/database.php';
                $stmt=$pdo->prepare("INSERT INTO categorie (nomcat, descriptioncat) VALUES (?, ?)");
                $stmt->execute([$nom, $description]);
        ?>
                    <div class="alert alert-success" role="alert">
                        La catégorie <?php echo $nom ?> est ajoutée avec succès !
                    </div>
            <?php 
            }else{
            ?>
                    <div class="alert alert-danger" role="alert">
                    Nom et description sont obligatoires ! 
                    </div>
                <?php 
            }
        }
        ?>
    <form method="post">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required>

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" ></textarea>

        <input type="submit" name="ajouter_cat" value="Ajouter catégorie" class="btn btn-success my-2">

    </form>
    </div>
</body>
</html>