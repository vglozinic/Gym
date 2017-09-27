<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $moderatori = Array();

    $upit = "SELECT id_korisnik, ime, prezime FROM korisnik WHERE id_uloga = 2;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $ime, $prezime) = $rezultat->fetch_array()) {
            array_push($moderatori, array(
                "id" => $id, 
                "ime" => $ime,
                "prezime" => $prezime,
            ));
        }
    }

    $database->dbclose();
    echo json_encode($moderatori);

?>