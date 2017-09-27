<?php

    require ("biblioteka.php");
    session_timeout();

    $id = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($_SESSION["uloga"] != 2){

        $upit = "INSERT INTO polaznik VALUES (NULL, 'DA', 'NE', " . $id . ", " . $_SESSION["id"] . ");";
        $database->dbselect($upit);

        dodaj_bodove("Prijava u program", 100, $_SESSION["id"], $_SESSION["uloga"]);
        dodaj_dnevnik(NULL,"Upis u program","Ostale radnje",$_SESSION["id"]);

        $upit = "UPDATE program SET broj_polaznika = broj_polaznika + 1 WHERE id_program = " . $id . ";";
        $database->dbselect($upit);
        
    }

    echo json_encode("success");
    $database->dbclose();
    
?>