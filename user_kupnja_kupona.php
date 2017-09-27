<?php

    require ("biblioteka.php");
    session_timeout();

    $database = new Baza();
    $database->dbconnect();

    $cijena = 0;
    foreach ($_SESSION["kosarica"] as $kljuc => $vrijednost) {
        $cijena += $vrijednost["broj"];
    }

    if ($cijena > stanje_bodova()) {
        echo json_encode(stanje_bodova());
    }
    else {
        foreach ($_SESSION["kosarica"] as $kljuc => $vrijednost) {
            $datum = date("Y-m-d H:i:s", time() + pomak());
            $codebook = "0123456789";
            $kod = substr(str_shuffle($codebook), 0, 10); 

            $upit = "INSERT INTO kosarica VALUES(" . $_SESSION["id"] . ", " . $vrijednost["id"] . ", '" . $kod . "','" . $datum . "');";
            $database->dbselect($upit);

            $upit = "UPDATE korisnik SET bodovi = bodovi - " . $vrijednost["broj"] . " WHERE id_korisnik = " . $_SESSION["id"] . ";";
            $database->dbselect($upit);

            dodaj_bodove("Kupnja kupona", -$vrijednost["broj"], $_SESSION["id"], $_SESSION["uloga"]);
        }

        dodaj_bodove("Kupnja kupona", 100, $_SESSION["id"], $_SESSION["uloga"]);
        dodaj_dnevnik(NULL,"Kupnja kupona","Ostale radje",$_SESSION["id"]);

        $_SESSION["kosarica"] = Array();
        echo json_encode("success");
    }
?>