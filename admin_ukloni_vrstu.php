<?php

    require ("biblioteka.php");
    session_timeout();

    $database = new Baza();
    $database->dbconnect();

    $status = "";
    $id = $_GET["id"];

    $upit = "SELECT * FROM trener WHERE id_vrsta = " . $id . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $status = "error";
    }

    $upit = "SELECT * FROM program WHERE id_vrsta = " . $id . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $status = "error";
    }

    if($status === ""){
        $upit = "DELETE FROM vrsta WHERE id_vrsta = " . $id . ";";
        $rezultat = $database->dbselect($upit);
        echo json_encode("success");
    }
    else{
        echo json_encode("error");
    }

    $database->dbclose();

?>