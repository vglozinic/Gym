<?php

    require ("biblioteka.php");
    session_timeout();

    $program = "";
    $korisnik = "";
    if(isset($_GET["program"])){
        $program = $_GET["program"];
    }
    if(isset($_GET["korisnik"])){
        $korisnik = $_GET["korisnik"];
    }
    $zabrani = $_GET["zabrani"];

    $database = new Baza();
    $database->dbconnect();

    $upit = "UPDATE polaznik SET zabranjen='" . $zabrani . "' WHERE id_program = " . $program . " AND id_korisnik = " . $korisnik . ";";
    $rezultat = $database->dbselect($upit);

    if($zabrani === "DA"){
        dodaj_dnevnik(NULL,"Zabrana korisniku","Ostale radnje",$_SESSION["id"]);
    }

    echo json_encode("success");
    $database->dbclose();

?>