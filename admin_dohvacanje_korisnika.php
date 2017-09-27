<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $korisnici = Array();

    $upit = "SELECT id_korisnik, ime, prezime FROM korisnik WHERE id_uloga = 1;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $ime, $prezime) = $rezultat->fetch_array()) {
            array_push($korisnici, array(
                "id" => $id, 
                "ime" => $ime,
                "prezime" => $prezime
            ));
        }
        echo json_encode($korisnici);
    }
    else{
        echo json_encode("empty"); 
    }

    $database->dbclose();

?>