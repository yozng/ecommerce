<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>connexion</title>
</head>
<body>
    <?php include 'include/nav.php' ?>
    <div class="container">
        <?php
       if(isset($_POST['connexion'])){
            $login = $_POST['login'];
            $pwd = $_POST['password'];

            if(!empty($login) && !empty($pwd)){
                require 'include/database.php';
                $stmt=$pdo->prepare("SELECT * FROM utilisateurs WHERE login=? AND password=?");
                $stmt->execute([$login, $pwd]);

                if($stmt->rowCount() >= 1){
                    $user = $stmt->fetch(); 
                    $_SESSION['utilisateur'] = $user;

                    if($user['role'] === 'admin'){
                        header('Location: admin.php');
                    } else if($user['role'] === 'client'){
                        header('Location: client.php');
                    }
                }else{
                    ?>
                        <div class="alert alert-danger" role="alert">
                        Login ou password sont incorrectes ! 
                        </div>
                    <?php 
                        
                    }
                }else{
                    ?>
                        <div class="alert alert-danger" role="alert">
                        Login et password sont obligatoires ! 
                        </div>
                    <?php 
                }
             }
         ?>
    <h4>
    Connexion
    </h4>
    <form method="post">
        <label class="form-label">Login</label>
        <input type="text" class="form-control" name="login">

        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password">

        <input type="submit" value="Connexion" class="btn btn-primary my-2" name="connexion">

    </form>
    </div>
</body>
</html>