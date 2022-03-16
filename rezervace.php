<!doctype html>
<html lang="cs" class="h-100">
    <!-- import head.php -->
    <?php
        include 'head.php';
        include 'database.php';

        if (je_spravce($pdo)){
            $dotaz = $pdo->prepare("SELECT * FROM rezervace ORDER BY datum_od");
            $dotaz->execute();
        }
        else{
            $dotaz = $pdo->prepare("SELECT * FROM rezervace where uzivatel_id = ? ORDER BY datum_od");
            $dotaz->execute(array(get_prihlaseny_uzivatel($pdo)['id']));
        }       
        $vsechny_rezervace = $dotaz->fetchAll();
    ?>
    <body class="d-flex flex-column h-100">
        <!-- import header.php - menu -->
        <?php
            include 'header.php';
        ?>

        <main style="padding: 60px 0 0">
            <div class="flex aligns-items-center">
                <div class="container p-5">
                    <?php if (sizeof($vsechny_rezervace) == 0): ?>
                        <div class="row">
                            <h2>Nejsou k dispozici žádné rezervace.</h2>
                            <a href="index.php" class="btn btn-zluty">Zpět na titulní stranu</a>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($vsechny_rezervace as $rezervace): ?>
                        <div class="row">
                            <?php
                                $uzivatel = get_uzivatel($pdo, $rezervace['uzivatel_id']);
                                $vozidlo = get_vozidlo($pdo, $rezervace['vozidlo_id']);
                            ?>
                            <div class="col-3">
                                <div class="card shadow-sm">
                                    <img src="<?php echo $vozidlo['foto'] ?>" alt="<?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?>" class="img-fluid">
                                    <div class="card-body">
                                        <h4><?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?></h4>
                                        <p class="card-text">ID vozidla: <span><?php echo $vozidlo['id'] ?></span></p>
                                        <p class="card-text">ID rezervace: <span><?php echo $rezervace['id'] ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h4>Rezervace uživatele: <span><?php echo $uzivatel['jmeno'] . " " .  $uzivatel['prijmeni'] ?></span></h4>
                                        <p>Termín výpůjčky: <span><?php echo date('d.m.Y', $rezervace['datum_od']) ?></span> ~ <span><?php echo date('d.m.Y', $rezervace['datum_do']) ?></span> (počet dní: <span><?php echo $rezervace['pocet_dni'] ?></span>)</p>
                                        <p>Cena: <?php echo $rezervace['cena'] ?> Kč</p>
                                        <p>Limit kilometrů: <?php echo $rezervace['limit_km'] ?> km</p>
                                        <?php if (je_spravce($pdo)): 
                                            if ($rezervace['schvaleno'] == true):?>
                                                <button class="btn btn-lg btn-success">Schváleno</button>
                                            <?php elseif (is_null($rezervace['schvaleno'])):?>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-lg btn-danger schvaleni-btn" href="schvaleni.php?id=<?php echo $rezervace['id'] ?>&stav=odmitnout">Odmítnout</button>
                                                    <button class="btn btn-lg btn-zluty schvaleni-btn" href="schvaleni.php?id=<?php echo $rezervace['id'] ?>&stav=schvalit">Schválit</button>
                                                </div>
                                            <?php elseif ($rezervace['schvaleno'] == false):?>
                                                <button class="btn btn-lg btn-danger">Neschváleno</button>
                                            <?php endif; ?>

                                        <?php else: 
                                            if ($rezervace['schvaleno'] == true):?>
                                                <button class="btn btn-lg btn-success">Schváleno</button>
                                            <?php elseif (is_null($rezervace['schvaleno'])):?>
                                                <button class="btn btn-lg btn-warning">Čeká na schválení</button>
                                            <?php elseif ($rezervace['schvaleno'] == false):?>
                                                <button class="btn btn-lg btn-danger">Neschváleno</button>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>   
                    <?php endforeach; ?>
                </div>
            </div>
        </main>

        <!-- import footer.php paticka -->
        <?php
            include 'footer.php';
        ?>
        <script type="text/javascript">
            $( document ).ready(function() {
                $('.container').on('click', '.schvaleni-btn', function(event){
                    event.preventDefault();
                    var url = $(this).attr('href');
                    $.ajax({
                        type: 'GET',
                        url: url,
                        success: function(data, status, jqXHR) {
                            location.reload();
                        },
                    });
                });
                return false;
            });
        </script>
    </body>
</html>
