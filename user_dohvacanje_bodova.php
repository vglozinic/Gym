<?php

    require ("biblioteka.php");
    session_timeout();
    
    $bodovi["statistika"] = Array();
    $bodovi["radnje"] = Array();
    $bodovi["broj"] = 0;
    $bodovi["ukupno"] = 0;
    $bodovi["zbroj"] = 0;

    $stranica = $_GET["stranica"];
    $zapisi = $_GET["zapisi"];

    if(isset($_GET["radnja"])){
        $radnja = $_GET["radnja"];
    }
    if(isset($_GET["order"])){
        if ($_GET["order"] == "") {
            $order  = "DESC";
        }
        else{
            $order = $_GET["order"];
        }
    }

    $database = new Baza();
    $database->dbconnect();

    $where = "";
    $limit = "LIMIT " . ($zapisi*($stranica-1)) . ", " . $zapisi;

    if($radnja === "All"){
        $where = "";
    }
    else{
        $where = " AND radnja = '" . $radnja . "'";

        $upit = "SELECT SUM(broj_bodova) as zbroj FROM statistika WHERE id_korisnik = " . $_SESSION["id"] . " AND broj_bodova > 0" . $where . ";";
        $rezultat = $database->dbselect($upit);
        $zbroj = $rezultat->fetch_object();
        $bodovi["zbroj"] = $zbroj->zbroj;
    }

    $upit = "SELECT radnja, broj_bodova, datum as zbroj FROM statistika WHERE id_korisnik = " . $_SESSION["id"] . " AND broj_bodova > 0" . $where . " ORDER BY datum " . $order . " " . $limit . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($radnja, $broj, $datum) = $rezultat->fetch_array()) {
            array_push($bodovi["statistika"], array(
                "radnja" =>$radnja,
                "broj" =>$broj,
                "datum" =>$datum
            ));
        }
    }

    $upit = "SELECT broj_bodova FROM korisnik WHERE id_korisnik = " . $_SESSION["id"] . ";";
    $rezultat = $database->dbselect($upit);
    $arbeit = $rezultat->fetch_object();
    $bodovi["broj"] = $arbeit->broj_bodova;

    $upit = "SELECT * FROM statistika WHERE id_korisnik = " . $_SESSION["id"] . " AND broj_bodova > 0" . $where . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $bodovi["ukupno"] = $rezultat->num_rows;
    }

    $upit = "SELECT DISTINCT radnja FROM statistika WHERE id_korisnik = " . $_SESSION["id"] . " AND broj_bodova > 0;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($radnja) = $rezultat->fetch_array()){
            array_push($bodovi["radnje"], $radnja);
        }
    }

    echo json_encode($bodovi);
    $database->dbclose();
    

?>