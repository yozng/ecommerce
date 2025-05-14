<?php
include 'include/nav.php';
require 'include/database.php';
if(isset($_POST['connexion'])){
    $login = $_POST['login'];
    $pwd = $_POST['password'];
    if(!empty($login) && !empty($pwd)){
        $stmt=$pdo->prepare("SELECT * FROM utilisateurs WHERE login=? AND password=?");
        $stmt->execute([$login, $pwd]);
        if($stmt->rowCount() >= 1){
            $_SESSION['utilisateur'] = $stmt->fetch();
            if($_SESSION['utilisateur']['role'] === 'admin'){
                header('Location: admin.php');
                exit;
            } else if($_SESSION['utilisateur']['role'] === 'client'){
                header('Location: client.php');
                exit;
            }else{
                echo '<div class="alert alert-danger" role="alert">Login ou password sont incorrectes ! </div>';
            }
        }else{
            echo'<div class="alert alert-danger" role="alert">Login et password sont obligatoires ! </div>';
            }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Connexion</title>
</head>
<body>
    <div class="container mt-4">
    <h4>Connexion</h4>
    <form method="post">
        <label class="form-label">Login</label>
        <input type="text" class="form-control" name="login" required>

        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>

        <input type="submit" value="Connexion" class="btn btn-primary my-2" name="connexion">

    </form>
    </div>
</body>
</html>