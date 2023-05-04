entre liste des disques et la liste 
Faire un encadrer ajouter recemment des 5 derniers disques avec leur image en petit


<div class="recently-added">
        <div class="row d-flex align-items-center justify-content-start">
            <h2 class="col-md-3">Ajouts récent :</h2>
            <?php
            // Requête SQL pour sélectionner les 5 derniers enregistrements de la table disc
            $recent_sql = "SELECT * 
        FROM disc
        JOIN artist ON disc.artist_id = artist.artist_id
        ORDER BY disc_id DESC
        LIMIT 5";
            $recent_stmt = $pdo->query($recent_sql);

            // Boucle pour afficher les disques récemment ajoutés
            while ($recent_row = $recent_stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="row col-md-2 d-flex flex-column gy-2">
                    <!-- <div class="card border-0"> -->
                    <img src="src/img/jaquettes/<?= $recent_row['disc_picture']; ?>" class="card-img-top" alt="Jaquette">
                    <span class="text-center artist-name"><?= $recent_row['artist_name']; ?></span>
                    <span class="text-center disc-title"><?= $recent_row['disc_title']; ?></span>
                    <!-- </div> -->
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    ----------------------------------------------------------
    css


   .recently-added {
    margin-bottom: 10px;
    margin-top: 10px;
    /* padding: 20px; */
    /* background-color: #f8f9fa; */
}

.recently-added h2 {
    font-weight: bold;
    text-transform: uppercase;
}

.recently-added .card {
    border: none;
}

.recently-added .card-img-top {
    width: 100%;
    height: auto;
    max-height: 50px;
    object-fit: contain;
}

.recently-added .card-body {
    padding: 10px;
}

.recently-added .artist-name {
    font-weight: bold;
    /* margin-bottom: 5px; */
}

.recently-added .disc-title {
    font-size: 12px;
}
