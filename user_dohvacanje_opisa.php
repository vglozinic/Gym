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

    $upit = "SELECT p.id_program, p.naziv, p.opis, p.mjesec, p.godina, p.broj_polaznika, p.broj_mjesta, p.aktivan, v.naziv, k.ime, k.prezime FROM program p
            INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
            INNER JOIN trener t ON t.id_trener = p.id_trener
            INNER JOIN korisnik k ON k.id_korisnik = t.id_korisnik
            WHERE p.id_program = " . $id . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id_program, $naziv, $opis, $mjesec, $godina, $bp, $bm, $aktivan, $vrsta, $ime, $prezime) = $rezultat->fetch_array()) {
            if($bp == $bm){
                $popunjeno = "DA";
            }
            else{
                $popunjeno = "NE";
            }
            array_push($programi["program"], array(
                "id" =>$id_program,
                "naziv" =>$naziv,
                "opis" => $opis,
                "mjesec" => $mjesec,
                "godina" => $godina,
                "vrsta" =>$vrsta,
                "ime" =>$ime,
                "prezime" =>$prezime,
                "popunjeno" =>$popunjeno
            ));
        }
    }

    $upit = "SELECT dan, od, do FROM termin WHERE id_program = " . $id . " AND aktivan = 'DA';";
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