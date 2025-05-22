<?php foreach ($produit as $produit1){ ?>
            <div class="col-md-4 mb-4">
               <div class="card h-100">
            <!--<form method="POST" action="ajouter_panier.php" class="card">-->
            <img src="../upload/produit/<?php echo $produit1['image'] ?>" class="card-img-top w-50 mx-auto" alt="<?php echo $produit1['nomp'] ?>" width="200" height="300">
            <div class="card-body">
                <a href="produit.php?id=<?php echo $produit1['id_produit'] ?>" class="btn stretched-link">Afficher détails</a>
                <h5 class="card-title"><?php echo $produit1['nomp'] ?></h5>
                <p class="card-text"><?php echo $produit1['description'] ?></p>
                <p class="card-text"><?php echo $produit1['prix'] ?> MAD</p>
                <p class="card-text"><small class="text-body-secondary">Last updated : <?php echo date_format(date_create($produit1['date_creationp']), 'Y/m/d'); ?></small></p>
             </div>
             
            <div class="card-footer text-center" >
                <button type="submit" class="btn btn-success btn-sm ms-2">Ajouter</button>
            </div>
              </div>
            <?php } 
            if (empty($produit)) {
                ?><div class="alert alert-info" role="alert">Aucun produit trouvé dans cette catégorie ! </div><?php
            }
            ?>
            </div>
        </div>
    </div>
    </div>