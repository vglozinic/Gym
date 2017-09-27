<?php

    require ("baza_class.php");
    
    $dnevnik["dnevnik"] = Array();
    $dnevnik["tipovi"] = Array();
    $dnevnik["korisnici"] = Array();
    $dnevnik["ukupno"] = 0;

    $stranica = $_GET["stranica"];
    $zapisi = $_GET["zapisi"];
    if(isset($_GET["tip"])){
        $tip = $_GET["tip"];
    }
    if(isset($_GET["korisnik"])){
        $korisnik = $_GET["korisnik"];
    }
    if(isset($_GET["order"])){
        $order = $_GET["order"];
    }
    else {
        $order = "";
    }

    $database = new Baza();
    $database->dbconnect();

    $where = "";
    $limit = "LIMIT " . ($zapisi*($stranica-1)) . ", " . $zapisi;

    if ($tip === "All" && $korisnik === "all") {
        $where = "";
    }
    else {
        if ($tip !== "All" && $korisnik === "all"){
            $where = "WHERE d.tip_radnje = '" .  $tip. "'";
        } 
        if ($tip === "All" && $korisnik !== "all"){
            $where = "WHERE k.username = '" . $korisnik . "'";
        } 
        if ($tip !== "All" && $korisnik !== "all"){
            $where = "WHERE d.tip_radnje = '" . $tip . "' AND k.username = '" . $korisnik . "'";
        } 
    }

    $upit = "SELECT d.id_dnevnik, d.upit, d.radnja, d.vrijeme, d.tip_radnje, k.username 
            FROM dnevnik d INNER JOIN korisnik k ON d.id_korisnik = k.id_korisnik " . $where . " ORDER BY d.vrijeme " . $order . " " . $limit . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $upit, $radnja, $vrijeme, $tip, $username) = $rezultat->fetch_array()) {
            array_push($dnevnik["dnevnik"], array(
                "id" => $id,
                "upit" => htmlspecialchars($upit),
                "radnja" => $radnja,
                "vrijeme" => $vrijeme,
                "tip" => $tip,
                "username" => $username
            ));
        }
    }

    $upit = "SELECT * FROM dnevnik d INNER JOIN korisnik k ON d.id_korisnik = k.id_korisnik " . $where;
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $dnevnik["ukupno"] = $rezultat->num_rows;
    }

    $upit = "SELECT DISTINCT tip_radnje FROM dnevnik;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($tip) = $rezultat->fetch_array()) {
            array_push($dnevnik["tipovi"], $tip);
        }
    }

    $upit = "SELECT DISTINCT k.username FROM dnevnik d INNER JOIN korisnik k ON d.id_korisnik = k.id_korisnik;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($username) = $rezultat->fetch_array()) {
            array_push($dnevnik["korisnici"], $username);
        }
    }

    $database->dbclose();
    echo json_encode($dnevnik);

?>