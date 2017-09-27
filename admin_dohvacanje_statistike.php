<?php

    require ("baza_class.php");
    
    $statistika["statistika"] = Array();
    $statistika["radnje"] = Array();
    $statistika["korisnici"] = Array();
    $statistika["ukupno"] = 0;

    $stranica = $_GET["stranica"];
    $zapisi = $_GET["zapisi"];
    if(isset($_GET["radnja"])){
        $radnja = $_GET["radnja"];
    }
    if(isset($_GET["korisnik"])){
        $korisnik = $_GET["korisnik"];
    }
    if(isset($_GET["operator"])){
        $operator = $_GET["operator"];
    }
    if(isset($_GET["order"])){
        if ($_GET["order"] == "") {
            $order  = "DESC";
        }
        else{
            $order = $_GET["order"];
        }
    }
    if(isset($_GET["datum"])){
        $datum = $_GET["datum"];
    }
    else {
        $datum = "";
    }

    $database = new Baza();
    $database->dbconnect();

    $where = "";
    $limit = "LIMIT " . ($zapisi*($stranica-1)) . ", " . $zapisi;

    if ($radnja === "All" && $korisnik === "all") {
        $where = "WHERE s.broj_bodova " . $operator . " 0";
    }
    else {
        if ($radnja !== "All" && $korisnik === "all"){
            $where = "WHERE s.radnja = '" .  $radnja . "' AND s.broj_bodova " . $operator . " 0";
        } 
        if ($radnja === "All" && $korisnik !== "all"){
            $where = "WHERE k.username = '" . $korisnik . "' AND s.broj_bodova " . $operator . " 0";
        } 
        if ($radnja !== "All" && $korisnik !== "all"){
            $where = "WHERE s.radnja = '" . $radnja . "' AND k.username = '" . $korisnik . "' AND s.broj_bodova " . $operator . " 0";
        } 
    }

    $upit = "SELECT s.id_statistika, s.radnja, s.broj_bodova, s.datum, k.ime, k.prezime
            FROM statistika s INNER JOIN korisnik k ON s.id_korisnik = k.id_korisnik " . $where . " ORDER BY s.broj_bodova " . $order . ", s.datum " . $datum . " " . $limit . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $radnja, $broj, $datum, $ime, $prezime) = $rezultat->fetch_array()) {
            array_push($statistika["statistika"], array(
                "id" => $id,
                "radnja" => $radnja,
                "broj" => $broj,
                "datum" => $datum,
                "ime" => $ime,
                "prezime" => $prezime
            ));
        }
    }

    $upit = "SELECT * FROM statistika s INNER JOIN korisnik k ON s.id_korisnik = k.id_korisnik " . $where;
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $statistika["ukupno"] = $rezultat->num_rows;
    }

    $upit = "SELECT DISTINCT radnja FROM statistika;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($radnja) = $rezultat->fetch_array()) {
            array_push($statistika["radnje"], $radnja);
        }
    }

    $upit = "SELECT DISTINCT(k.username), k.ime, k.prezime FROM statistika s INNER JOIN korisnik k ON s.id_korisnik = k.id_korisnik;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($username, $ime, $prezime) = $rezultat->fetch_array()) {
            array_push($statistika["korisnici"], array(
                "username" => $username,
                "ime" => $ime,
                "prezime" => $prezime
            ));
        }
    }

    $database->dbclose();
    echo json_encode($statistika);

?>