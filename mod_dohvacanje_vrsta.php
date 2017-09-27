<?php

    require ("baza_class.php");
    session_start();
    
    $vrste = Array();

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT v.id_vrsta, v.naziv 
            FROM vrsta v 
            INNER JOIN trener t ON v.id_vrsta = t.id_vrsta
            WHERE t.id_korisnik = " . $_SESSION["id"] . " ORDER BY naziv ASC;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $naziv) = $rezultat->fetch_array()) {
            array_push($vrste, array("id" => $id, "naziv" => $naziv));
        }
        echo json_encode($vrste);
    }
    else{
        echo json_encode("empty");
    }

    $database->dbclose();

?>