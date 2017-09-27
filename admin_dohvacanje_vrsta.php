<?php

    require ("biblioteka.php");

    $naziv = "";
    if(isset($_GET["naziv"])){
        $naziv = $_GET["naziv"];
    }
    else{
        $naziv = "all";
    }

    $database = new Baza();
    $database->dbconnect();

    $vrste = Array();

    if($naziv === "all"){
        $upit = "SELECT naziv FROM vrsta;";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($naziv) = $rezultat->fetch_array()) {
                array_push($vrste, $naziv);
            }
            echo json_encode($vrste);
        }
        else{
            echo json_encode("");
        }

        $database->dbclose();
    }
    else{
        $upit = "SELECT naziv FROM vrsta WHERE naziv = '" . $naziv . "';";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            echo json_encode("exists");
        }
        else{
            echo json_encode("");
        }

        $database->dbclose();
    }

?>