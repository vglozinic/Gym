<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $program["dostupno"] = Array();
    $program["trener"] = Array();
    $id = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $upit = "SELECT p.id_vrsta, k.ime, k.prezime, k.username
            FROM program p
            INNER JOIN trener t ON p.id_trener = t.id_trener
            INNER JOIN korisnik k ON k.id_korisnik = t.id_korisnik 
            WHERE p.id_program = " . $id . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $trener = $rezultat->fetch_object();
        $program["trener"] = array(
            "id" => $trener->id_vrsta,
            "ime" => $trener->ime,
            "prezime" => $trener->prezime,
            "username" => $trener->username
        );
    }

    $upit = "SELECT DISTINCT(k.username), k.ime, k.prezime, k.id_korisnik
            FROM trener t 
            INNER JOIN korisnik k ON k.id_korisnik = t.id_korisnik
            WHERE t.id_vrsta = " . $program["trener"]["id"] . " AND NOT k.username = '" . $program["trener"]["username"] . "';";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($username, $ime, $prezime, $id) = $rezultat->fetch_array()) {
            array_push($program["dostupno"], array(
                "username" =>$username,
                "ime" => $ime,
                "prezime" => $prezime,
                "id" => $id
            ));
        }
    }

    $database->dbclose();
    echo json_encode($program);

?>