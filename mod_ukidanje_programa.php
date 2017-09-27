<?php

    require ("biblioteka.php");
    session_timeout();

    dodaj_dnevnik(NULL,"Ukidanje programa","Ostale radnje",$_SESSION["id"]);

    $id = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $database = new Baza();
    $database->dbconnect();

    $upit = "UPDATE program SET aktivan = 'NE' WHERE id_program = " . $id .  ";";
    $rezultat = $database->dbselect($upit);

    $upit = "UPDATE polaznik SET aktivan = 'NE' WHERE id_program = " . $id .  ";";
    $rezultat = $database->dbselect($upit);

    $upit = "UPDATE termin SET aktivan = 'NE' WHERE id_program = " . $id .  ";";
    $rezultat = $database->dbselect($upit);

    $upit = "UPDATE popust SET aktivan = 'NE' WHERE id_program = " . $id .  ";";
    $rezultat = $database->dbselect($upit);
        
    echo json_encode("success");
    $database->dbclose();

?>