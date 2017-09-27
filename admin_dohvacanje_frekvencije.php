<?php

    require ("biblioteka.php");
    session_timeout();

    $freq = "DESC";
    if(isset($_GET["freq"])){
        $freq = $_GET["freq"];
    }
    $stranica = $_GET["stranica"];
    $zapisi = $_GET["zapisi"];

    $vraceno["frekvencija"] = Array();
    $vraceno["ukupno"] = 0;

    $limit = "LIMIT " .( $zapisi*($stranica-1)) . ", " . $zapisi;

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT k.ime, k.prezime, k.username, k.email, u.naziv, count(k.id_korisnik) AS broj
             FROM dnevnik d
             INNER JOIN korisnik k ON d.id_korisnik = k.id_korisnik
             INNER JOIN uloga u ON k.id_uloga = u.id_uloga
             GROUP BY k.id_korisnik
             ORDER BY broj " . $freq . " " . $limit .  ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($ime, $prezime, $username, $email, $naziv, $broj) = $rezultat->fetch_array()) {
            array_push($vraceno["frekvencija"], array(
                "ime" => $ime,
                "prezime" => $prezime,
                "username" => $username,
                "email" => $email,
                "naziv" => $naziv,
                "broj" => $broj
            ));
        }
    }

    $upit = "SELECT k.ime, k.prezime, k.username, k.email, u.naziv, count(k.id_korisnik) AS broj
             FROM dnevnik d
             INNER JOIN korisnik k ON d.id_korisnik = k.id_korisnik
             INNER JOIN uloga u ON k.id_uloga = u.id_uloga
             GROUP BY k.id_korisnik
             ORDER BY broj " . $freq . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $vraceno["ukupno"] = $rezultat->num_rows;
    }

    $database->dbclose();
    echo json_encode($vraceno);

?>