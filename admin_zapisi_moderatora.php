<?php

    require ("biblioteka.php");
    session_timeout();

    $id = "";
    $success = "success";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }
    else{
        $success = "error";
    }

    $database = new Baza();
    $database->dbconnect();

    if($id !== ""){
        $upit = "UPDATE korisnik SET id_uloga = 2 WHERE id_korisnik = " . $id . ";";
        $rezultat = $database->dbselect($upit);
    }

    $database->dbclose();
    echo json_encode($success);

?>