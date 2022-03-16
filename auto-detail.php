<!doctype html>
<html lang="cs" class="h-100">
    <!-- import head.php -->
    <?php
        include 'head.php';
        include 'database.php';

        $dotaz = $pdo->prepare("SELECT * FROM vozidlo WHERE id = ?");
        $dotaz->execute(array($_GET['id']));
        $vozidlo = $dotaz->fetch();

        if(isset($_POST["rezervovat"]))  
        {
            if(empty($_POST["start"]) || empty($_POST["end"]))  {  
                 alert('Je nutné vyplnit všechna pole');  
            }
            else if( isset($_SESSION["uzivatel"])){
                rezervace($pdo, $_POST["start"], $_POST["end"], $_GET['id']);
            }
            else{
                alert('Nejprve se přihlaste.');  
            }
        }

    ?>
    <body class="d-flex flex-column h-100">
        <!-- import header.php - menu -->
        <?php
            include 'header.php';
        ?>

        <main style="padding: 60px 0 0">
            <div class="flex aligns-items-center">
                <div class="container p-5">
                    <div class="row">
                        <div class="col-6">
                        <img src="<?php echo $vozidlo['foto'] ?>" alt="<?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?>" class="img-fluid">
                        </div>
                        <div class="col-6">
                            <form id="rezervace-form" method="post">
                                <h3><?php echo $vozidlo['znacka'] . " " .  $vozidlo['model'] ?></h3>
                                <h4>Požadovaná rezervace</h4>
                                <div class="input-daterange input-group" id="datepicker">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="">Termín</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Datum vyzvednutí" id="datum_od" name="start">
                                    <input type="text" class="form-control" placeholder="Datum vrácení" id="datum_do" name="end">
                                </div>
                                <div id="rezervace" style="display: none;">
                                    <table class="table">
                                        <tr>
                                            <th>Počet dní</th>
                                            <td><span id="dni">7674</span></td>
                                        </tr>
                                        <tr>
                                            <th>Celková cena</th>
                                            <td><span id="cena">7674</span> Kč</td>
                                        </tr>
                                        <tr>
                                            <th>Nájezd v ceně (nezahrnuje náklady na palivo)</th>
                                            <td><span id="najezd">7674</span> km</td>
                                        </tr>
                                        <tr>
                                            <th>Cena za km nad limit</th>
                                            <td><?php echo $vozidlo['cena_km'] ?> Kč/km</td>
                                        </tr>
                                    </table>
                                    <button class="w-100 btn btn-lg btn-zluty" id="rezervovat" name="rezervovat" type="submit">Rezervovat</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <hr>
                            <h4>O autě</h4>
                            <p>
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Duis bibendum, lectus ut viverra rhoncus, dolor nunc faucibus libero, eget facilisis enim ipsum id lacus. Integer rutrum, orci vestibulum ullamcorper ultricies, lacus quam ultricies odio, vitae placerat pede sem sit amet enim. Nullam rhoncus aliquam metus. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Pellentesque sapien. Fusce aliquam vestibulum ipsum. Curabitur vitae diam non enim vestibulum interdum. Integer pellentesque quam vel velit. Nullam rhoncus aliquam metus. Praesent vitae arcu tempor neque lacinia pretium. Ut tempus purus at lorem. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos.
                            </p>
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
        </main>

        <!-- import footer.php paticka -->
        <?php
            include 'footer.php';
        ?>
        <script>
        $('#datepicker').datepicker({
            format: "dd.mm.yyyy",
            startDate: "today",
            language: "cs",
            autoclose: true,
            todayHighlight: true
        }).on("changeDate", function(e) {
            if ($('#datum_od').datepicker('getDate') & $('#datum_do').datepicker('getDate')){
                vypocet();
                $('#rezervace').show();
            }
            else{
                $('#rezervace').hide();
            }
        });
        function vypocet(){
            var dt1 = $('#datum_od').datepicker('getDate');
            var dt2 = $('#datum_do').datepicker('getDate');
            var pocet_dni = Math.round(((dt2.getTime()-dt1.getTime())/86400000)+1);
            $('#dni').text(pocet_dni);
            $('#cena').text(spocitej_cenu(pocet_dni));
            $('#najezd').text(pocet_dni*<?php echo $vozidlo['denni_najezd'] ?>);
        };
        function spocitej_cenu(dni){
            if(dni<=2){
                return dni*<?php echo $vozidlo['cena1'] ?>;
            }
            else if(dni<=10){
                return dni*<?php echo $vozidlo['cena2'] ?>;
            }
            else if(dni<30){
                return dni*<?php echo $vozidlo['cena3'] ?>;
            }
            else if(dni=>30){
                return dni*<?php echo $vozidlo['cena4'] ?>;
            }
        };
        </script>
    </body>
</html>