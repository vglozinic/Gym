<?php

    require ("biblioteka.php");
    session_timeout();

    $termini = Array();
    
    $id = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT id_termin, od, do, dan FROM termin WHERE aktivan = 'DA' AND id_program = " . $id .  " ORDER BY dan<>'Ponedjeljak' ASC, dan<>'Utorak' ASC, dan<>'Srijeda' ASC, dan<>'Četvrtak' ASC, dan<>'Petak';";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($id, $od, $do, $dan) = $rezultat->fetch_array()) {
            array_push($termini, array(
                "id" =>$id,
                "od" => $od,
                "do" => $do,
                "dan" => $dan
            ));
        }
        echo json_encode($termini);
    }
    else{
        echo json_encode("empty");
    }

    $database->dbclose();
    

?>