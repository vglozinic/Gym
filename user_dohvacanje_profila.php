<?php

    require ("biblioteka.php");
    session_timeout();

    $profil = Array();

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT ime, prezime, username, email, mobitel, dual_login FROM korisnik WHERE id_korisnik = " . $_SESSION["id"] . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($ime, $prezime, $username, $email, $mobitel, $dual) = $rezultat->fetch_array()) {
            array_push($profil, array(
                "ime" =>$ime,
                "prezime" =>$prezime,
                "username" =>$username,
                "mobitel" =>$mobitel,
                "email" =>$email,
                "dual" =>$dual
            ));
        }
    }

    echo json_encode($profil);
    $database->dbclose();
    

?>