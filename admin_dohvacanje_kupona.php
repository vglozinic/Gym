<?php

    require ("baza_class.php");
    
    $kuponi = Array();
    $exists = "nope";
    $check = "no";
    $id = "";
    if(isset($_GET["check"])){
        $check = $_GET["check"];
    }
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($check === "no"){
        $upit = "SELECT * FROM kupon;";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($id, $naziv, $pdf, $slika, $video) = $rezultat->fetch_array()) {
                array_push($kuponi, array(
                    "id" => $id,
                    "naziv" => $naziv,
                    "pdf" => $pdf,
                    "slika" => $slika,
                    "video" => $video
                ));
            }
        }
        echo json_encode($kuponi);
    }
    else{
        $upit = "SELECT COUNT(*) AS broj FROM popust WHERE id_kupon = " . $id . ";";
        $rezultat = $database->dbselect($upit);
        $broj = $rezultat->fetch_object();

        if($broj->broj != 0){
            $exists = "exists";
        }
        else{
            $exists = "nope";
        }
        echo json_encode($exists);
    }

    $database->dbclose();
    

?>