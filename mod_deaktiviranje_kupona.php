<?php

    require ("biblioteka.php");
    session_timeout();

    dodaj_dnevnik(NULL,"Deaktiviranje kupona","Ostale radnje",$_SESSION["id"]);

    $program = "";
    $kupon = "";
    if(isset($_GET["program"])){
        $program = $_GET["program"];
    }
    if(isset($_GET["kupon"])){
        $kupon = $_GET["kupon"];
    }

    $all = "NE";
    if(isset($_GET["all"])){
        $all = $_GET["all"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($all === "DA"){
        $upit = "UPDATE popust SET aktivan = 'NE' WHERE id_program = " . $program . ";";
    }
    else{
        $upit = "UPDATE popust SET aktivan = 'NE' WHERE id_program = " . $program .  " AND id_kupon = " . $kupon . ";";
    }

    $database->dbselect($upit);
    echo json_encode("success");
    $database->dbclose();

?>