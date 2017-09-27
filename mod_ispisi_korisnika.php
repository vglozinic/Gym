<?php

    require ("biblioteka.php");
    session_timeout();

    dodaj_dnevnik(NULL,"Ispisivanje polaznika","Ostale radnje",$_SESSION["id"]);

    $program = "";
    $korisnik = "";
    if(isset($_GET["program"])){
        $program = $_GET["program"];
    }
    if(isset($_GET["korisnik"])){
        $korisnik = $_GET["korisnik"];
    }

    $database = new Baza();
    $database->dbconnect();

    $upit = "UPDATE polaznik SET aktivan='NE' WHERE id_program = " . $program . " AND id_korisnik = " . $korisnik . ";";
    $rezultat = $database->dbselect($upit);

    $upit = "UPDATE program SET broj_polaznika = broj_polaznika - 1 WHERE id_program = " . $program . ";";
    $rezultat = $database->dbselect($upit);

    echo json_encode("success");
    $database->dbclose();

?>