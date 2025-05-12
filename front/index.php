<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <title>Liste des catégories</title>
</head>
<body>
    <?php include '../include/nav_front.php' ?>
    <div class="container py-2">
    <h4>Liste des catégories</h4>
    <?php 
     require_once '../include/database.php';
        $stmt = $pdo->query("SELECT * FROM categorie");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <ul class="list-group list-group-flush w-25" >
        <?php foreach ($categories as $categorie){ ?>
            <li class="list-group-item">
                <a class="btn btn-light" href="categorie.php?id=<?php echo $categorie['id_categorie']; ?>">
                    <?php echo $categorie['nomcat']; ?>
                </a>
            </li>
        <?php } ?>
    </ul>
    </div>
  </div>
</div>
    </div>
</body>
</html>