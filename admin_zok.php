<?php

    require ("biblioteka.php");
    session_timeout();

    $success = "success";
    $id = $_GET["id"];

    $database = new Baza();
    $database->dbconnect();

    if($id === "all"){
        $upit = "UPDATE korisnik SET zabranjen = 'NE' WHERE NOT id_korisnik = " . $_SESSION["id"] . ";";
    }
    else{
        $upit = "UPDATE korisnik SET zabranjen = 'NE' WHERE id_korisnik = " . $id . ";";
    }

    $database->dbselect($upit);
    $database->dbclose();
    echo json_encode($success);

?>