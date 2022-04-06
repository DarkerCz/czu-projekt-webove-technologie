<?php
    session_start();
    include 'db_connection.php';

    $dsn = 'pgsql:dbname=' . SQL_DBNAME . ';host=' . SQL_HOST . '';
    $user = SQL_USERNAME;
    $password = SQL_PASSWORD;

    try {
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
    }



    function existujeEmail(PDO $pdo, $email) {
        $dotaz = $pdo->prepare("SELECT 1 FROM uzivatel WHERE email = ?");
        $dotaz->execute(array($email));
        $existuje = $dotaz->fetchColumn();
        return $existuje;

    }

    function login(PDO $pdo, $email, $heslo){
        if(existujeEmail($pdo, $email)){
            $dotaz = $pdo->prepare("SELECT email, heslo, spravce FROM uzivatel WHERE email = ?");
            $dotaz->execute(array($email));
            $uzivatel = $dotaz->fetch();
            if(password_verify($heslo, $uzivatel["heslo"])){
                $_SESSION['uzivatel'] = $uzivatel["email"];
                header("location:index.php"); 
                return true;
            }
        }
        else{
            alert("Nesprávné heslo");
            return false;
        }
    }

    function je_spravce(PDO $pdo){
        if( isset($_SESSION["uzivatel"])){
            $dotaz = $pdo->prepare("SELECT * FROM uzivatel WHERE email = ?");
            $dotaz->execute(array($_SESSION['uzivatel']));
            $uzivatel = $dotaz->fetch();
            return $uzivatel['spravce'];
        }
        return false;
    }

    function get_uzivatel(PDO $pdo, $uzivatel_id){
        $dotaz = $pdo->prepare("SELECT * FROM uzivatel WHERE id = ?");
        $dotaz->execute(array($uzivatel_id));
        $uzivatel = $dotaz->fetch();
        return $uzivatel;
    }

    function get_prihlaseny_uzivatel(PDO $pdo){
        $dotaz = $pdo->prepare("SELECT * FROM uzivatel WHERE email = ?");
        $dotaz->execute(array($_SESSION['uzivatel']));
        $uzivatel = $dotaz->fetch();
        return $uzivatel;
    }

    function get_vozidlo(PDO $pdo, $vozidlo_id){
        $dotaz = $pdo->prepare("SELECT * FROM vozidlo WHERE id = ?");
        $dotaz->execute(array($vozidlo_id));
        $vozidlo = $dotaz->fetch();
        return $vozidlo;
    }

    function register(PDO $pdo, $email, $heslo, $jmeno, $prijmeni, $telefon){
        $dotaz = $pdo->prepare("INSERT into uzivatel (jmeno, prijmeni, email, heslo, telefon) VALUES(?, ?, ?, ?, ?)");
        $vysledek = $dotaz->execute(array(
            $jmeno, 
            $prijmeni,
            $email,
            password_hash($heslo, PASSWORD_DEFAULT),
            $telefon
        ));
        $insertId = $pdo->lastInsertId();
        if($insertId){
            $_SESSION['uzivatel'] = $email;
            header("location:index.php"); 
        }
        else{
            return false;
        }
    }

    function rezervace($pdo, $datum_od, $datum_do, $id_vozidla){
        $dotaz = $pdo->prepare("SELECT * FROM uzivatel WHERE email = ?");
        $dotaz->execute(array($_SESSION['uzivatel']));
        $uzivatel = $dotaz->fetch();
        

        $dotaz = $pdo->prepare("SELECT * FROM vozidlo WHERE id = ?");
        $dotaz->execute(array($id_vozidla));
        $vozidlo = $dotaz->fetch();

        $od = strtotime($datum_od);
        $do = strtotime($datum_do);
        $datediff = $do - $od;
        $pocet_dni = (round($datediff / (60 * 60 * 24))+1);
        $cena = 0;
        $limit_km = $pocet_dni * $vozidlo['denni_najezd'];
        if ($pocet_dni <=2){
            $cena = $pocet_dni * $vozidlo['cena1'];
        }
        else if ($pocet_dni <= 10){
            $cena = $pocet_dni * $vozidlo['cena2'];
        }
        else if ($pocet_dni < 30){
            $cena = $pocet_dni * $vozidlo['cena3'];
        }
        else if ($pocet_dni >= 30){
            $cena = $pocet_dni * $vozidlo['cena4'];
        }

        $dotaz = $pdo->prepare("INSERT into rezervace (datum_od, datum_do, pocet_dni, cena, limit_km, uzivatel_id, vozidlo_id) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $vysledek = $dotaz->execute(array(
            $od, 
            $do,
            $pocet_dni,
            $cena,
            $limit_km,
            $uzivatel['id'],
            $vozidlo['id']
        ));
        $insertId = $pdo->lastInsertId();
        if($insertId){
            alert("Rezervace byla úspěšná");
            return true;
        }
        else{
            alert("Problém při zakládání rezervace");
            return false;
        }
    }

    function nove_vozidlo(PDO $pdo, $znacka, $model, $rok_vyroby, $spotreba, $nadrz, $hmotnost, $objem_motoru, $vykon, $karoserie, $pocet_mist, $prevodovka, $cena1, $cena2, $cena3, $cena4, $denni_najezd, $cena_km, $foto, $palivo){
        if (je_spravce($pdo)){
            $dotaz = $pdo->prepare("INSERT into vozidlo (znacka, model, rok_vyroby, spotreba, nadrz, hmotnost, objem_motoru, vykon, karoserie, pocet_mist, prevodovka, cena1, cena2, cena3, cena4, denni_najezd, cena_km, foto, palivo) 
                VALUES(:znacka, :model, :rok_vyroby, :spotreba, :nadrz, :hmotnost, :objem_motoru, :vykon, :karoserie, :pocet_mist, :prevodovka, :cena1, :cena2, :cena3, :cena4, :denni_najezd, :cena_km, :foto, :palivo)");
            $vysledek = $dotaz->execute(array(
                ":znacka" => $znacka,
                ":model" => $model,
                ":rok_vyroby" => $rok_vyroby,
                ":spotreba" => $spotreba,
                ":nadrz" => $nadrz,
                ":hmotnost" => $hmotnost,
                ":objem_motoru" => $objem_motoru,
                ":vykon" => $vykon,
                ":karoserie" => $karoserie,
                ":pocet_mist" => $pocet_mist,
                ":prevodovka" => $prevodovka,
                ":cena1" => $cena1,
                ":cena2" => $cena2,
                ":cena3" => $cena3,
                ":cena4" => $cena4,
                ":denni_najezd" => $denni_najezd,
                ":cena_km" => $cena_km,
                ":foto" => $foto,
                ":palivo" => $palivo                
            ));
            $insertId = $pdo->lastInsertId();
            if($insertId){
                alert("Vozidlo bylo úspěšně uloženo");
                header('Location: seznam_vozidel.php');
            }
        }
        alert("Problém při zakládání vozidla");
        return false;
    }

    function editace_vozidla(PDO $pdo, $id, $znacka, $model, $rok_vyroby, $spotreba, $nadrz, $hmotnost, $objem_motoru, $vykon, $karoserie, $pocet_mist, $prevodovka, $cena1, $cena2, $cena3, $cena4, $denni_najezd, $cena_km, $foto, $palivo){
        if (je_spravce($pdo)){
            $dotaz = $pdo->prepare("UPDATE vozidlo SET znacka=:znacka, model=:model, rok_vyroby=:rok_vyroby, spotreba=:spotreba, nadrz=:nadrz, hmotnost=:hmotnost, objem_motoru=:objem_motoru, vykon=:vykon, karoserie=:karoserie, pocet_mist=:pocet_mist, prevodovka=:prevodovka,
             cena1=:cena1, cena2=:cena2, cena3=:cena3, cena4=:cena4, denni_najezd=:denni_najezd, cena_km=:cena_km, foto=:foto, palivo=:palivo WHERE id =:id");
            $vysledek = $dotaz->execute(array(
                ":znacka" => $znacka,
                ":model" => $model,
                ":rok_vyroby" => $rok_vyroby,
                ":spotreba" => $spotreba,
                ":nadrz" => $nadrz,
                ":hmotnost" => $hmotnost,
                ":objem_motoru" => $objem_motoru,
                ":vykon" => $vykon,
                ":karoserie" => $karoserie,
                ":pocet_mist" => $pocet_mist,
                ":prevodovka" => $prevodovka,
                ":cena1" => $cena1,
                ":cena2" => $cena2,
                ":cena3" => $cena3,
                ":cena4" => $cena4,
                ":denni_najezd" => $denni_najezd,
                ":cena_km" => $cena_km,
                ":foto" => $foto,
                ":palivo" => $palivo,
                ":id" => $id,
            ));
            if($vysledek){
                alert("Vozidlo bylo úspěšně uloženo");
                header('Location: seznam_vozidel.php');
            }
        }
        alert("Problém při editaci vozidla");
        return false;
    }

    function alert($msg) {
        echo "<script type='text/javascript'>alert('$msg');</script>";
    }
?>
