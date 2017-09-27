<?php

    require ("biblioteka.php");
    session_timeout();

    $database = new Baza();
    $database->dbconnect();

    $moderator = $_GET["moderator"];

    $upit = "SELECT * FROM program p INNER JOIN trener t
            ON p.id_trener = t.id_trener
            WHERE t.id_korisnik = " . $moderator . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        echo json_encode("error");
    }
    else{
        $upit = "DELETE FROM trener WHERE id_korisnik = " . $moderator . ";";
        $rezultat = $database->dbselect($upit);

        $upit = "UPDATE korisnik SET id_uloga = 1 WHERE id_korisnik = " . $moderator . ";";
        $rezultat = $database->dbselect($upit);

        echo json_encode("success");
    }

    $database->dbclose();

?>