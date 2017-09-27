<?php

    require ("biblioteka.php");
    session_timeout();
    
    $programi["program"] = Array();
    $programi["termini"] = Array();

    $id = "";
    $termin = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT p.naziv, p.opis, p.mjesec, p.godina, p.broj_polaznika, p.broj_mjesta, p.aktivan, v.naziv FROM program p
            INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
            WHERE p.id_program = " . $id . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($naziv, $opis, $mjesec, $godina, $bp, $bm, $aktivan, $vrsta) = $rezultat->fetch_array()) {
            if($aktivan === "DA"){
                $termin = "DA";
            }
            else{
                $termin = "NE";
            }
            array_push($programi["program"], array(
                "naziv" =>$naziv,
                "opis" => $opis,
                "mjesec" => $mjesec,
                "godina" => $godina,
                "bp" =>$bp,
                "bm" =>$bm,
                "aktivan" =>$aktivan,
                "vrsta" =>$vrsta
            ));
        }
    }

    if($termin === "DA"){
        $upit = "SELECT dan, od, do FROM termin 
        WHERE id_program = " . $id . " AND aktivan = 'DA';";
    }
    else{
        $upit = "SELECT dan, od, do FROM termin 
        WHERE id_program = " . $id . ";";
    }

    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($dan, $od, $do) = $rezultat->fetch_array()) {
            array_push($programi["termini"], array(
                "dan" =>$dan,
                "od" => $od,
                "do" => $do
            ));
        }
    }
    else{
        $programi["termini"] = "empty";
    }

    echo json_encode($programi);
    $database->dbclose();
    

?>