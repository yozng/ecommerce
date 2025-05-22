<?php 
include 'include/nav.php';
?>
<h2>Nos jeux les plus populaires</h2>
<div class="row">
  <?php
  include 'include/database.php'; 
  $req = $pdo->query("SELECT * FROM produits LIMIT 4");
  while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
      echo "
      <div class='col-md-3'>
        <div class='card mb-4'>
          <img src='images/{$row['image']}' class='card-img-top' alt='jeu'>
          <div class='card-body'>
            <h5 class='card-title'>{$row['nomp']}</h5>
            <p class='card-text'>{$row['prix']} DH</p>
            <a href='details.php?id={$row['id_produit']}' class='btn btn-primary btn-sm'>Voir</a>
          </div>
        </div>
      </div>";
  }
  ?>
</div>
<?php include 'include/footer.php'; ?>
