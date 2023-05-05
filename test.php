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


------------------------------------------------------------------------------
<!-- Encadré "Ajouté récemment" -->
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h4>Ajouté récemment :</h4>
            <div id="recent-carousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicateurs -->
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i < $recent_count; $i++) { ?>
                        <li data-bs-target="#recent-carousel" data-bs-slide-to="<?= $i ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                    <?php } ?>
                </ol>

                <!-- Slides -->
                <div class="carousel-inner">
                    <?php $first = true; ?>
                    <?php while ($recent_row = $recent_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="carousel-item <?php if ($first) echo 'active'; ?>">
                            <img src="src/img/jaquettes/<?= $recent_row['disc_picture']; ?>" alt="Jaquette" class="d-block mx-auto" style="width: 200px; height: 200px; object-fit: cover;">
                            <div class="text-center mt-2">
                                <div><?= $recent_row['disc_title']; ?></div>
                                <div><?= $recent_row['artist_name']; ?></div>
                            </div>
                        </div>
                        <?php $first = false; ?>
                    <?php } ?>
                </div>

                <!-- Contrôles -->
                <a class="carousel-control-prev" href="#recent-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#recent-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Suivant</span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Fin de l'encadré "Ajouté récemment" -->

<!-- Script pour activer le carrousel -->
<script>
    $(document).ready(function() {
        $('#recent-carousel').carousel();
    });
</script>
