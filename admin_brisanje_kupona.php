<?php

    require ("biblioteka.php");
    session_timeout();

    $database = new Baza();
    $database->dbconnect();

    $id = $_GET["id"];
    $upit = "SELECT * FROM kupon WHERE id_kupon = " . $id . ";";
    $rezultat = $database->dbselect($upit);
    $objekt = $rezultat->fetch_object();

    unlink($objekt->pdf_putanja);
    unlink($objekt->slika_putanja);
    if($objekt->video_putanja !== null){
        unlink($objekt->video_putanja);
    }

    $upit = "DELETE FROM kupon WHERE id_kupon = " . $id . ";";
    $rezultat = $database->dbselect($upit);

    echo json_encode("success");
    $database->dbclose();

?>