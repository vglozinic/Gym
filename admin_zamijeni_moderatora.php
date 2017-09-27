<?php

    require ("biblioteka.php");
    session_timeout();

    $korisnik = "";
    $program = "";
    $all = "";
    if(isset($_GET["korisnik"])){
        $korisnik = $_GET["korisnik"];
    }
    if(isset($_GET["program"])){
        $program = $_GET["program"];
    }
    if(isset($_GET["all"])){
        $all = $_GET["all"];
    }
    
    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT id_trener FROM trener
    WHERE id_korisnik = " . $korisnik . " AND id_vrsta = 
    (SELECT id_vrsta FROM program WHERE id_program = " . $program . ")";
    $rezultat = $database->dbselect($upit);
    $trener = $rezultat->fetch_object();

    if($all !== "ALL"){
        $upit = "UPDATE program SET id_trener = " . $trener->id_trener . " WHERE id_program = " . $program . ";";
        $rezultat = $database->dbselect($upit);
    }
    else{
        $upit = "UPDATE program SET id_trener = " . $trener->id_trener .  
        " WHERE id_trener = (SELECT id_trener FROM (SELECT * FROM program) AS tablica WHERE id_program = " . $program . ");";
        $rezultat = $database->dbselect($upit);
    }

    echo json_encode("success");
    $database->dbclose();

?>