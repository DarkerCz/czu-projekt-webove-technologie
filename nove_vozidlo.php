<!doctype html>
<html lang="cs" class="h-100">
    <!-- import head.php -->
    <?php
        include "head.php";
        include "database.php";
        if (!je_spravce($pdo)){
            header("location:index.php");
        }

        if(isset($_POST["nove_vozidlo"]))  
        {
            if(empty($_POST["znacka"]) || empty($_POST["model"]) || empty($_POST["rok_vyroby"]) || empty($_POST["spotreba"]) || 
                empty($_POST["nadrz"]) || empty($_POST["hmotnost"]) || empty($_POST["objem_motoru"]) || empty($_POST["vykon"]) || 
                empty($_POST["karoserie"]) || empty($_POST["pocet_mist"]) || empty($_POST["prevodovka"]) || empty($_POST["cena1"]) || 
                empty($_POST["cena2"]) || empty($_POST["cena3"]) || empty($_POST["cena4"]) || empty($_POST["denni_najezd"]) || 
                empty($_POST["cena_km"]) || empty($_POST["foto"]) || empty($_POST["palivo"])){             
                    alert("Je nutné vyplnit všechna pole");  
            }
            else{
                nove_vozidlo($pdo, $_POST["znacka"], $_POST["model"], $_POST["rok_vyroby"], $_POST["spotreba"], 
                $_POST["nadrz"], $_POST["hmotnost"], $_POST["objem_motoru"], $_POST["vykon"], 
                $_POST["karoserie"], $_POST["pocet_mist"], $_POST["prevodovka"], $_POST["cena1"], 
                $_POST["cena2"], $_POST["cena3"], $_POST["cena4"], $_POST["denni_najezd"], 
                $_POST["cena_km"], $_POST["foto"], $_POST["palivo"]);
            }
        }
    ?>
    <body class="d-flex flex-column h-100">
        <!-- import header.php - menu -->
        <?php
            include "header.php";
        ?>

        <main style="padding: 60px 0 0">
            <div class="flex aligns-items-center">
                <div class="container p-5">
                    <div class="row">
                        <form class="nove-vozidlo-form" method="post">
                            <h1 class="h3 mb-3 fw-normal">Nové vozidlo</h1>
                            <div class="form-floating"><input type="text" class="form-control" id="znacka" name="znacka" required>
                                <label for="znacka">Značka</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="text" class="form-control" id="model" name="model" required>
                                <label for="model">Model</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="rok_vyroby" name="rok_vyroby" min="1990" required>
                                <label for="rok_vyroby">Rok výroby</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="spotreba" name="spotreba" min="1" max="100" required>
                                <label for="spotreba">Spotřeba (l/100km)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="nadrz" name="nadrz" min="0" max="150" required>
                                <label for="nadrz">Velikost nádrže</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="hmotnost" name="hmotnost" min="100" max="3500" required>
                                <label for="hmotnost">Hmotnost (kg)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="objem_motoru" name="objem_motoru" min="125" max="8000" required>
                                <label for="objem_motoru">Objem motoru (ccm)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="vykon" name="vykon" min="1" max="1000" required>
                                <label for="vykon">Výkon (kW)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="text" class="form-control" id="karoserie" name="karoserie" required>
                                <label for="karoserie">Karosérie</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="pocet_mist" name="pocet_mist" min="1" max="8" required>
                                <label for="pocet_mist">Počet míst</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="text" class="form-control" id="prevodovka" name="prevodovka" required>
                                <label for="prevodovka">Převodovka</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="cena1" name="cena1" min="0" max="3000" required>
                                <label for="cena1">Cena do dvou dní (cena za den)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="cena2" name="cena2" min="0" max="3000" required>
                                <label for="cena2">Cena do deseti dní (cena za den)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="cena3" name="cena3" min="0" max="3000" required>
                                <label for="cena3">Cena do třiceti dní (cena za den)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="cena4" name="cena4" min="0" max="3000" required>
                                <label for="cena4">Cena nad třicet dní (cena za den)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="denni_najezd" name="denni_najezd" min="50" max="500" required>
                                <label for="denni_najezd">Denní nájezd v ceně (km)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="number" class="form-control" id="cena_km" name="cena_km" min="0" max="100" required>
                                <label for="cena_km">Cena za km nad limit (Kč)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="text" class="form-control" id="foto" name="foto" required>
                                <label for="foto">Foto (url)</label>
                            </div>
                            <br>
                            <div class="form-floating"><input type="text" class="form-control" id="palivo" name="palivo" required>
                                <label for="palivo">Palivo</label>
                            </div>
                            <br>



                            <button class="w-100 btn btn-lg btn-zluty submit" type="submit" name="nove_vozidlo">Uložit</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <!-- import footer.php paticka -->
        <?php
            include "footer.php";
        ?>
    </body>
</html>
