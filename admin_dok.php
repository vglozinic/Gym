<?php

    require ("biblioteka.php");
    session_start();

    $database = new Baza();
    $database->dbconnect();

    $korisnici = Array();

    $upit = "SELECT id_korisnik, ime, prezime, username, email, naziv 
    FROM korisnik JOIN uloga 
    ON uloga.id_uloga = korisnik.id_uloga 
    WHERE zabranjen = 'NE' AND NOT id_korisnik = " . $_SESSION["id"] . " ORDER BY korisnik.id_uloga DESC, korisnik.id_korisnik ASC;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $ime, $prezime, $username, $email, $naziv) = $rezultat->fetch_array()) {
            array_push($korisnici, array(
                "id" => $id, 
                "ime" => $ime, 
                "prezime" => $prezime, 
                "username" => $username, 
                "email" => $email,
                "naziv" => $naziv
            ));
        }
    }

    $database->dbclose();
    echo json_encode($korisnici);

?>