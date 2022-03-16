<?php
    include 'database.php';

    if(je_spravce($pdo)){
        $stav = NULL;
        if ($_GET["stav"] == 'schvalit'){
            $stav = 1;
        }
        else if ($_GET["stav"] == 'odmitnout'){
            $stav = 0;
        }
        $dotaz = $pdo->prepare("UPDATE rezervace SET schvaleno = ? WHERE id = ?");
        $vysledek = $dotaz->execute(array($stav, $_GET["id"]));
        return true;
    }
    else{
        alert("Nedostatečné oprávnění.");
        return false;
    }

?>