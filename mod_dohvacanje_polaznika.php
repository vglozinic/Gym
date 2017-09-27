<?php

    require ("biblioteka.php");
    session_timeout();

    $polaznici = Array();
    
    $id = "";
    $locked = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }
    if(isset($_GET["locked"])){
        $locked = $_GET["locked"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($locked === "DA"){
        $upit = "SELECT k.id_korisnik, k.ime, k.prezime
                FROM polaznik p INNER JOIN korisnik k ON k.id_korisnik = p.id_korisnik
                WHERE p.id_program = " . $id . " AND p.aktivan = 'DA' AND p.zabranjen = 'DA' ORDER BY k.ime ASC;";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($id, $ime, $prezime) = $rezultat->fetch_array()) {
                array_push($polaznici, array(
                    "id" => $id,
                    "ime" => $ime,
                    "prezime" => $prezime
                ));
            }
            echo json_encode($polaznici);
        }
        else{
            echo json_encode("none");
        }
    }
    else{
        $upit = "SELECT k.id_korisnik, k.ime, k.prezime, k.email, k.spol, k.datrod, k.mobitel, k.broj_bodova
                FROM polaznik p INNER JOIN korisnik k ON k.id_korisnik = p.id_korisnik
                WHERE p.id_program = " . $id . " AND p.zabranjen = 'NE' AND p.aktivan = 'DA' ORDER BY k.ime ASC;";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($id, $ime, $prezime, $email, $spol, $datum, $broj, $bodovi) = $rezultat->fetch_array()) {
                array_push($polaznici, array(
                    "id" => $id,
                    "ime" => $ime,
                    "prezime" => $prezime,
                    "email" => $email,
                    "spol" => $spol,
                    "datum" => $datum,
                    "broj" => $broj,
                    "bodovi" => $bodovi
                ));
            }
            echo json_encode($polaznici);
        }
        else{
            echo json_encode("none");
        }
    }

    $database->dbclose();
    

?>