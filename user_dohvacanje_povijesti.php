<?php

    require ("biblioteka.php");
    session_timeout();
    
    $povijest["kosarica"] = Array();
    $povijest["ukupno"] = 0;

    $stranica = $_GET["stranica"];
    $zapisi = $_GET["zapisi"];

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

    $limit = "LIMIT " . ($zapisi*($stranica-1)) . ", " . $zapisi;

    $upit = "SELECT n.naziv, k.datum, m.naziv, m.mjesec, m.godina, k.kod, p.potrebno 
            FROM kosarica k
            INNER JOIN popust p ON p.id_popust = k.id_popust
            INNER JOIN kupon n ON n.id_kupon = p.id_kupon
            INNER JOIN program m ON m.id_program = p.id_program
            WHERE k.id_korisnik = " . $_SESSION["id"] . " ORDER BY k.datum " . $order . " " . $limit . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($kupon, $datum, $program, $mjesec, $godina, $kod, $potrebno) = $rezultat->fetch_array()) {
            array_push($povijest["kosarica"], array(
                "kupon" =>$kupon,
                "datum" =>$datum,
                "program" =>$program,
                "mjesec" =>$mjesec,
                "godina" =>$godina,
                "kod" =>$kod,
                "potrebno" =>$potrebno
            ));
        }
    }

    $upit = "SELECT * FROM kosarica WHERE id_korisnik = " . $_SESSION["id"] . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $povijest["ukupno"] = $rezultat->num_rows;
    }

    echo json_encode($povijest);
    $database->dbclose();
    
?>