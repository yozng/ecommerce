    <?php session_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <title>Admin</title>
    </head>
    <body>
        <?php include 'include/nav.php' ?>
    <div class="container">
        <?php 
        if(!isset($_SESSION['utilisateurs'])|| $_SESSION['utilisateurs']['role'] !== 'admin') {
            header('Location: connexion.php');
            exit;
        }
        ?>
        <h4> Bienvenue Admin <?php echo $_SESSION['utilisateurs']['prenom'] ?></h4>
    </div>
    </body>
    </html>
