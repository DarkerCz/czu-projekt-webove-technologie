<!doctype html>
<html lang="cs" class="h-100">
    <!-- import head.php -->
    <?php
        include 'head.php';
        include 'database.php';

        $dotaz = $pdo->prepare("SELECT * FROM vozidlo");
        $dotaz->execute();
        $vozidla = $dotaz->fetchAll();

    ?>
    <body class="d-flex flex-column h-100">
        <!-- import header.php - menu -->
        <?php
            include 'header.php';
        ?>

        <main style="padding: 60px 0 0">
            <div class="flex aligns-items-center">
                <div class="col-12 jumbotron">
                    <h1 class="p-5 text-white text-center">Autopůjčovna</h1>
                    <h3 class="p-5 pb-5 text-white text-center">Lorem ipsum dolor sit amet, <br>consectetuer adipiscing elit. Nunc auctor. Proin pede metus, vulputate nec, <br>fermentum fringilla, vehicula vitae, justo. <br>Nulla turpis magna, cursus sit amet, suscipit a, <br>interdum id, felis.</h3>
                </div>
            </div>
            <div class="flex aligns-items-center">
                <div class="container p-5">
                    <div class="row">
                        <div class="col-6">
                            <h4>O nás</h4>
                            <h2>Vítejte v naší autopůjčovně</h2>
                            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc auctor. Proin pede metus, vulputate nec, fermentum fringilla.</p>
                            <div class="about-list">
                                <ul style="list-style-type: none;">
                                    <li><i class="fa fa-check"></i>Jsme ...</li>
                                    <li><i class="fa fa-check"></i>Jsme ...</li>
                                    <li><i class="fa fa-check"></i>Jsme ...</li>
                                    <li><i class="fa fa-check"></i>Jsme ...</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-6">
                            <img src="assets/img/o-nas-auto.webp" alt="auto" class="img-fluid" width="1280" height="853">
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex aligns-items-center">
                <div class="col-12 dostupnost-panel promo-box-left">
                    <h4 class="p-5">Jsme Vám k dispozici 24 hodin denně, 7 dní v týdnu</h4>
                </div>
            </div>
            <div class="flex aligns-items-center">
                <div class="container p-5">
                    <div class="row">
                        <div class="album py-5 bg-light">
                            <div class="container">
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                                    <?php
                                        foreach ($vozidla as $vozidlo): ?>
                                            <div class="col">
                                                <div class="card shadow-sm">
                                                    <img src="<?php echo $vozidlo['foto'] ?>" alt="<?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?>" class="img-fluid">
                                                    <div class="card-body">
                                                        <h4><?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?></h4>
                                                        <p class="card-text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nunc auctor. Proin pede metus, vulputate nec, fermentum fringilla.</p>
                                                        <div>
                                                            <i class="fas fa-money-bill-alt text-zluta"></i>&nbsp;Od <?php echo $vozidlo['cena4'] ?>Kč/den
                                                            &nbsp;<i class="fa fa-cogs text-zluta"></i>&nbsp;<?php echo $vozidlo['prevodovka'] ?>
                                                            &nbsp;<i class="fas fa-gas-pump text-zluta"></i>&nbsp;<?php echo $vozidlo['palivo'] ?>
                                                        </div>
                                                        <a href="auto-detail.php?id=<?php echo $vozidlo['id'];?>" class="m-2 btn btn-sm btn-zluty float-right">Detail vozu</a>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- import footer.php paticka -->
        <?php
            include 'footer.php';
        ?>
      
    </body>
</html>
