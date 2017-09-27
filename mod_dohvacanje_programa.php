<?php

    require ("biblioteka.php");
    session_timeout();
    
    $programi = Array();
    if(isset($_GET["aktivan"])){
        $aktivan = $_GET["aktivan"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($_SESSION["uloga"] == 2){
        $upit = "SELECT p.id_program, p.naziv, p.mjesec, p.godina FROM program p
                INNER JOIN trener t ON t.id_trener = p.id_trener
                INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
                WHERE aktivan = '" . $aktivan . "' AND t.id_korisnik = " . $_SESSION["id"] .  ";";

        $rezultat = $database->dbselect($upit);
        if($rezultat->num_rows > 0){
            while (list($id, $naziv, $mjesec, $godina) = $rezultat->fetch_array()) {
                array_push($programi, array(
                    "id" =>$id,
                    "naziv" => $naziv,
                    "mjesec" => $mjesec,
                    "godina" => $godina
                ));
            }
            echo json_encode($programi);
        }
        else{
            echo json_encode("empty");
        }
    }

    if($_SESSION["uloga"] == 3){
        $upit = "SELECT p.id_program, p.naziv, p.mjesec, p.godina FROM program p
                INNER JOIN trener t ON t.id_trener = p.id_trener
                INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
                WHERE aktivan = '" . $aktivan . "';";

        $rezultat = $database->dbselect($upit);
        if($rezultat->num_rows > 0){
            while (list($id, $naziv, $mjesec, $godina) = $rezultat->fetch_array()) {
                array_push($programi, array(
                    "id" =>$id,
                    "naziv" => $naziv,
                    "mjesec" => $mjesec,
                    "godina" => $godina
                ));
            }
            echo json_encode($programi);
        }
        else{
            echo json_encode("empty");
        }
    }
    
    $database->dbclose();
    

?>