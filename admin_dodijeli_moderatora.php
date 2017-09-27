<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $vrsta = $_GET["vrsta"];
    $moderator = $_GET["moderator"];

    $upit = "SELECT * FROM trener WHERE id_vrsta = " . $vrsta . " AND id_korisnik = " . $moderator . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        echo json_encode("error");
    }
    else{
        $upit = "INSERT INTO trener VALUES (NULL, " . $moderator . ", " . $vrsta . ");";
        $rezultat = $database->dbselect($upit);
        echo json_encode("success");
    }

    $database->dbclose();

?>