<?php

    require ("biblioteka.php");
    session_timeout();
    
    $moderatori = Array();

    $id = "";
    $except = "false";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }
    if(isset($_GET["except"])){
        $except = $_GET["except"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($except === "false"){
        $upit = "SELECT k.id_korisnik, k.ime, k.prezime, k.username, k.email
        FROM korisnik k
        INNER JOIN trener t ON k.id_korisnik = t.id_korisnik
        INNER JOIN vrsta v ON v.id_vrsta = t.id_vrsta
        WHERE v.id_vrsta = " . $id . ";";

        $rezultat = $database->dbselect($upit);
        if($rezultat->num_rows > 0){
            while (list($id_korisnik, $ime, $prezime, $username, $email) = $rezultat->fetch_array()) {
                array_push($moderatori, array(
                    "id" =>$id_korisnik,
                    "ime" => $ime,
                    "prezime" => $prezime,
                    "username" => $username,
                    "email" => $email
                ));
            }
        }
    }
    else{
        $upit = "SELECT id_korisnik, ime, prezime FROM korisnik WHERE id_uloga = 2;";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($id_korisnik, $ime, $prezime) = $rezultat->fetch_array()) {
                array_push($moderatori, array(
                    "id" =>$id_korisnik,
                    "ime" => $ime,
                    "prezime" => $prezime
                ));
            }
        }

        $upit = "SELECT k.id_korisnik FROM trener t INNER JOIN korisnik k ON t.id_korisnik = k.id_korisnik WHERE t.id_vrsta = " . $id . ";";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($id_lel) = $rezultat->fetch_array()) {
                for($i = 0; $i < count($moderatori); $i++){
                    if($id_lel == $moderatori[$i]["id"]){
                        array_splice($moderatori,$i,1);
                    }
                }
            }
        }
    }

    $database->dbclose();
    echo json_encode($moderatori);

?>