<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $korisnici = Array();

    $upit = "SELECT k.id_korisnik, k.ime, k.prezime, u.naziv
            FROM korisnik k INNER JOIN uloga u ON u.id_uloga = k.id_uloga
            WHERE NOT k.id_uloga = 3 ORDER BY u.naziv DESC;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $ime, $prezime, $uloga) = $rezultat->fetch_array()) {
            array_push($korisnici, array(
                "id" => $id, 
                "ime" => $ime,
                "prezime" => $prezime,
                "uloga" => $uloga
            ));
        }
        echo json_encode($korisnici);
    }
    else{
        echo json_encode("empty"); 
    }

    $database->dbclose();

?>