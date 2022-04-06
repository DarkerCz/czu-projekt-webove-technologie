<!doctype html>
<html lang="cs" class="h-100">
    <!-- import head.php -->
    <?php
        include 'head.php';
        include 'database.php';

        $dotaz = $pdo->prepare("SELECT * FROM vozidlo ORDER BY id");
        $dotaz->execute();
        $vsechna_vozidla = $dotaz->fetchAll();
    ?>
    <body class="d-flex flex-column h-100">
        <!-- import header.php - menu -->
        <?php
            include 'header.php';
        ?>

        <main style="padding: 60px 0 0">
            <div class="flex aligns-items-center">
                <div class="container p-5">
                    <a id="nove-vozidlo-btn" class="btn btn-zluty btn-lg w-100" href="nove_vozidlo.php"><i class="fas fa-plus-circle"></i> Přidat vozidlo</a>
                    <hr>
                    <?php if (sizeof($vsechna_vozidla) == 0): ?>
                        <div class="row">
                            <h2>Nejsou k dispozici žádná vozidla.</h2>
                            <a href="index.php" class="btn btn-zluty">Zpět na titulní stranu</a>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($vsechna_vozidla as $vozidlo): ?>
                        <div class="row">
                            <div class="col-3">
                                <div class="card shadow-sm">
                                    <img src="<?php echo $vozidlo['foto'] ?>" alt="<?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?>" class="img-fluid">
                                    <div class="card-body">
                                        <h4><?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?></h4>
                                        <p class="card-text">ID vozidla: <span><?php echo $vozidlo['id'] ?></span></p>
                                        <a href="editace_vozidla.php?id=<?php echo $vozidlo['id'];?>" class="m-2 btn btn-sm btn-zluty float-right"><i class="fas fa-pencil-alt"></i> Editace</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h4><?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?></h4>
                                        <table class="table">
                                            <tr>
                                                <td><i class="far fa-calendar text-zluta"></i>&nbsp;Rok výroby</td>
                                                <td><?php echo $vozidlo['rok_vyroby'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-gas-pump text-zluta"></i>&nbsp;Palivo</td>
                                                <td><?php echo $vozidlo['palivo'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-tachometer-alt text-zluta"></i>&nbsp;Spotřeba</td>
                                                <td><?php echo $vozidlo['spotreba'] ?> l/100km</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-gas-pump text-zluta"></i>&nbsp;Kapacita nádrže</td>
                                                <td><?php echo $vozidlo['nadrz'] ?> l</td> 
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-weight-hanging text-zluta"></i>&nbsp;Hmotnost</td>
                                                <td><?php echo $vozidlo['hmotnost'] ?> kg</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-cogs text-zluta"></i>&nbsp;Objem motoru</td>
                                                <td><?php echo $vozidlo['objem_motoru'] ?> ccm</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-bolt text-zluta"></i>&nbsp;Výkon</td>
                                                <td><?php echo $vozidlo['vykon'] ?> kW</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-car text-zluta"></i>&nbsp;Karoserie</td>
                                                <td><?php echo $vozidlo['karoserie'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fas fa-chair text-zluta"></i>&nbsp;Počet míst</td>
                                                <td><?php echo $vozidlo['pocet_mist'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-cogs text-zluta"></i>&nbsp;Převodovka</td>
                                                <td><?php echo $vozidlo['prevodovka'] ?></td>
                                            </tr>
                                        </table>
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
