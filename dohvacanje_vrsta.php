<?php

    require ("biblioteka.php");
    session_timeout();
    
    $odabir = Array();

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT id_vrsta, naziv FROM vrsta ORDER BY naziv ASC;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id_vrsta, $naziv) = $rezultat->fetch_array()) {
            array_push($odabir, array("id_vrsta" => $id_vrsta, "naziv" => $naziv));
        }
    }
    else{
        $odabir = "empty";
    }

    $database->dbclose();
    echo json_encode($odabir);

?>