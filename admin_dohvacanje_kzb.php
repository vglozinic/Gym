<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $korisnici["korisnici"] = Array();
    $korisnici["ukupno"] = 0;
    

    $stranica = $_GET["stranica"];
    $zapisi = $_GET["zapisi"];

    $limit = "LIMIT " .( $zapisi*($stranica-1)) . ", " . $zapisi;

    if(isset($_GET["order"])){
        $order = " ORDER BY broj_bodova " . $_GET["order"];
    }
    else {
        $order = "";
    }

    $upit = "SELECT ime, prezime, username, email, broj_bodova FROM korisnik WHERE id_uloga = 1" . $order . " " . $limit . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($ime, $prezime, $username, $email, $broj_bodova) = $rezultat->fetch_array()) {
            array_push($korisnici["korisnici"], array(
                "ime" => $ime, 
                "prezime" => $prezime,
                "username" => $username,
                "email" => $email, 
                "broj_bodova" => $broj_bodova
            ));
        }
    }

    $upit = "SELECT * FROM korisnik WHERE id_uloga = 1" . $order . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $korisnici["ukupno"] = $rezultat->num_rows;
    }

    $database->dbclose();
    echo json_encode($korisnici);

?>