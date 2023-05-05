// Requête SQL pour sélectionner les 5 derniers disques ajoutés récemment
$recent_sql = "SELECT * 
               FROM disc
               JOIN artist ON disc.artist_id = artist.artist_id
               ORDER BY disc_id DESC
               LIMIT 5";
$recent_stmt = $pdo->query($recent_sql);




<!-- Encadré "Ajouté récemment" -->
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h4>Ajouté récemment :</h4>
            <div class="d-flex flex-wrap">
                <?php while ($recent_row = $recent_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                    <div class="me-3 mb-3">
                        <img src="src/img/jaquettes/<?= $recent_row['disc_picture']; ?>" alt="Jaquette" style="width: 50px; height: 50px; object-fit: cover;">
                        <div class="text-center" style="font-size: 12px; white-space: nowrap; width: 50px; overflow: hidden; text-overflow: ellipsis;">
                            <?= $recent_row['disc_title']; ?>
                        </div>
                        <div class="text-center" style="font-size: 12px; white-space: nowrap; width: 50px; overflow: hidden; text-overflow: ellipsis;">
                            <?= $recent_row['artist_name']; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- Fin de l'encadré "Ajouté récemment" -->