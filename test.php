<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Historique des 5 derniers disques ajoutés</h5>
                    <div class="row">
                        <?php
                        // Requête SQL pour sélectionner les 5 derniers enregistrements de la table disc
                        $history_sql = "SELECT * 
                        FROM disc
                        JOIN artist ON disc.artist_id = artist.artist_id
                        ORDER BY disc_id DESC
                        LIMIT 5";
                        $history_stmt = $pdo->query($history_sql);

                        // Boucle pour afficher les enregistrements de l'historique
                        while ($history_row = $history_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="col-md-2 text-center">
                                <img src="src/img/jaquettes/<?= $history_row['disc_picture']; ?>" class="card-img-top" alt="Jaquette" style="max-width: 50px;">
                                <p class="card-text"><span class="fw-bold">Titre: </span><?php echo $history_row['disc_title']; ?></p>
                                <p class="card-text"><span class="fw-bold">Artiste: </span><?php echo $history_row['artist_name']; ?></p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


-------------------------------------
edit 2

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center">Ajoutés récemment :</h5>
                    <div class="row d-flex justify-content-center">
                        <?php
                        // Requête SQL pour sélectionner les 5 derniers enregistrements de la table disc
                        $history_sql = "SELECT * 
                        FROM disc
                        JOIN artist ON disc.artist_id = artist.artist_id
                        ORDER BY disc_id DESC
                        LIMIT 5";
                        $history_stmt = $pdo->query($history_sql);

                        // Boucle pour afficher les enregistrements de l'historique
                        while ($history_row = $history_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="col-md-2 text-center">
                                <img src="src/img/jaquettes/<?= $history_row['disc_picture']; ?>" class="card-img-top" alt="Jaquette" style="max-width: 50px;">
                                <div class="mt-2">
                                    <p class="card-text">
                                        <span class="fw-bold">Titre:</span><br>
                                        <?php echo $history_row['disc_title']; ?>
                                    </p>
                                    <p class="card-text">
                                        <span class="fw-bold">Artiste:</span><br>
                                        <?php echo $history_row['artist_name']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


-----------------------------------------------
edit 3:
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title text-center" style="font-size: 18px;">Ajoutés récemment :</h5>
                    <div class="row d-flex justify-content-center">
                        <?php
                        // Requête SQL pour sélectionner les 5 derniers enregistrements de la table disc
                        $history_sql = "SELECT * 
                        FROM disc
                        JOIN artist ON disc.artist_id = artist.artist_id
                        ORDER BY disc_id DESC
                        LIMIT 5";
                        $history_stmt = $pdo->query($history_sql);

                        // Boucle pour afficher les enregistrements de l'historique
                        while ($history_row = $history_stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="col-md-2 text-center">
                                <img src="src/img/jaquettes/<?= $history_row['disc_picture']; ?>" class="card-img-top" alt="Jaquette" style="max-width: 50px;">
                                <div class="mt-2">
                                    <p class="card-text" style="font-size: 14px;">
                                        <span class="fw-bold">Titre:</span><br>
                                        <?php echo $history_row['disc_title']; ?>
                                    </p>
                                    <p class="card-text" style="font-size: 14px;">
                                        <span class="fw-bold">Artiste:</span><br>
                                        <?php echo $history_row['artist_name']; ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
