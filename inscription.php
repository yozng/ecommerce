<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Inscription</title>
</head>
<body>
    <?php include 'include/nav.php' ?>
    <div class="container">
        <?php
        if(isset($_POST['inscription'])) {
        $nom     = $_POST['nom'];
        $prenom  = $_POST['prenom'];
        $login   = $_POST['login'];
        $password= $_POST['password'];

            if (!empty($nom) && !empty($prenom) && !empty($login) && !empty($password)) {
                require 'include/database.php';

                $checkUser = $pdo->prepare("SELECT * FROM utilisateur WHERE login = ?");
                $checkUser->execute([$login]);
                if ($checkUser->rowCount() > 0) {
                    echo '<div class="alert alert-warning">Ce login est déjà utilisé.</div>';
                } else {
                $date=date('Y-m-d');
                $stmt=$pdo->prepare("INSERT INTO utilisateurs (login, password,nom,prenom,date_creation,role) VALUES (?, ?, ?, ?, 'client')");
                $stmt->execute([$login, $pwd, $nom, $prenom,$date]);
                echo '<div class="alert alert-success">Inscription réussie. Vous pouvez vous connecter.</div>';

                header('Location: connexion.php');
            }else{
        ?>
            <div class="alert alert-danger" role="alert">
            Login et password sont obligatoires ! 
            </div>
        <?php 
            
            }
        }
        ?>
    <h4>Inscription</h4>
    <form method="post">
        <label class="form-label">Nom</label>
        <input type="text" class="form-control" name="nom" required>

        <label class="form-label">Prénom</label>
        <input type="text" class="form-control" name="prenom" required>

        <label class="form-label">Login</label>
        <input type="text" class="form-control" name="login" required>

        <label class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password" required>

        <input type="submit" name="inscription" value="S'inscrire" class="btn btn-success my-2">

    </form>
    </div>
</body>
</html>