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
    <title>Ajouter catégorie</title>
</head>
<body>
    <div class="container">
        <h4>Ajouter une catégorie</h4>
        <?php
       if(isset($_POST['ajouter_cat'])){
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $icone = $_POST['icone'];


            if(!empty($nom) && !empty($description) && !empty($icone)){
                require 'include/database.php';
                $stmt=$pdo->prepare("INSERT INTO categorie (nomcat, descriptioncat,icone) VALUES (?,?,?)");
                $stmt->execute([$nom, $description,$icone]);
                header('Location: categories.php');
                exit;
                /*?>
                    <div class="alert alert-success" role="alert">
                        La catégorie <?php echo $nom ?> est ajoutée avec succès !
                    </div>
            <?php */
            }else{
                echo '<div class="alert alert-danger">Tous les champs sont obligatoires !</div>';
            }
        }
        ?>
    <form method="post">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required>

        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" ></textarea>

        <label class="form-label">Icône </label>
        <input type="text" class="form-control" name="icone" required>

        <input type="submit" name="ajouter_cat" value="Ajouter catégorie" class="btn btn-success my-2">

    </form>
    </div>
</body>
</html>
