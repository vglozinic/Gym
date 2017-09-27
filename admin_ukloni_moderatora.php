<?php

    require ("biblioteka.php");

    $database = new Baza();
    $database->dbconnect();

    $vrsta = $_GET["vrsta"];
    $moderator = $_GET["moderator"];

    $upit = "SELECT * FROM program p INNER JOIN trener t
            ON p.id_trener = t.id_trener
            WHERE t.id_korisnik = " . $moderator . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        echo json_encode("error");
    }
    else{
        $upit = "DELETE FROM trener WHERE id_vrsta = " . $vrsta . " AND id_korisnik = " . $moderator . ";";
        $rezultat = $database->dbselect($upit);
        echo json_encode("success");
    }

    $database->dbclose();

?>