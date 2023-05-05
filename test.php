<!-- Encadré "Ajouté récemment" -->
<div class="container">
    <div class="row mt-4">
        <div class="col">
            <h4 class="text-center">Ajouté récemment :</h4>
            <div id="recent-carousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicateurs -->
                <ol class="carousel-indicators">
                    <?php for ($i = 0; $i < $recent_count; $i++) { ?>
                        <li data-bs-target="#recent-carousel" data-bs-slide-to="<?= $i ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
                    <?php } ?>
                </ol>

                <!-- Slides -->
                <div class="carousel-inner d-flex justify-content-center">
                    <?php while ($recent_row = $recent_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <div class="carousel-item">
                            <img src="src/img/jaquettes/<?= $recent_row['disc_picture']; ?>" alt="Jaquette" class="d-block mx-auto" style="width: 50px; height: 50px; object-fit: cover;">
                            <div class="text-center mt-2">
                                <div><?= $recent_row['disc_title']; ?></div>
                                <div><?= $recent_row['artist_name']; ?></div>
                            </div>
                        </div>
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
