<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $programi = Array();
    $aktivan = "DA";
    if(isset($_GET["aktivan"])){
        $aktivan = $_GET["aktivan"];
    }

    $upit = "SELECT p.id_program, p.naziv, p.mjesec, p.godina, k.ime, k.prezime
            FROM program p
            INNER JOIN trener t ON p.id_trener = t.id_trener
            INNER JOIN korisnik k ON k.id_korisnik = t.id_korisnik 
            WHERE p.aktivan = '" . $aktivan . "';";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $naziv, $mjesec, $godina, $ime, $prezime) = $rezultat->fetch_array()) {
            array_push($programi, array(
                "id" => $id, 
                "naziv" => $naziv,
                "mjesec" => $mjesec,
                "godina" => $godina, 
                "ime" => $ime,
                "prezime" => $prezime
            ));
        }
        echo json_encode($programi);
    }
    else{
        echo json_encode("empty"); 
    }

    $database->dbclose();

?>