<?php

    require ("biblioteka.php");
    session_timeout();

    $error = "";
    $flag_aktivacija = false;

    $sesija = $_GET["sesija"];
    $bnp = $_GET["bnp"];
    $stranicenje = $_GET["stranicenje"];
    $aktivacija = $_GET["aktivacija"];

    $database = new Baza();
    $database->dbconnect();

    $regex = "/^[0-9]+$/";

    if(preg_match($regex, $aktivacija)){
        if(intval($aktivacija) >= 1 && intval($aktivacija) <= 720){
            $flag_aktivacija = true;
        }
        else{
            $flag_aktivacija = false;
        }
    }
    else{
        $flag_aktivacija = false;
    }
    
    if($flag_aktivacija){
        $statement = $database->veza->prepare("UPDATE config SET sesija = ?, bnp = ?, aktivacija = ?, stranicenje = ?");
        $statement->bind_param("iiii", intval($sesija), intval($bnp), intval($aktivacija), intval($stranicenje));
        $statement->execute();
        $statement->close();

        dodaj_dnevnik(NULL,"Promjena postavki sustava","Ostale radnje",$_SESSION["id"]);
    }
    else{
        $error = "error";
    }

    $database->dbclose();
    echo json_encode($error);

?>