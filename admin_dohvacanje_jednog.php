<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $id = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $upit = "SELECT email, dual_login, aktivan, broj_bodova FROM korisnik WHERE id_korisnik = " . $id . ";";
    $rezultat = $database->dbselect($upit);
    $podaci = $rezultat->fetch_object();

    echo json_encode($podaci);
    $database->dbclose();
    
?>