<?php

    require ("biblioteka.php");
    
    $postavke = Array();
    $config = postavke();

    $database = new Baza();
    $database->dbconnect();

    $postavke["sesija"] = $config->sesija;
    $postavke["bnp"] = $config->bnp;
    $postavke["stranicenje"] = $config->stranicenje;
    $postavke["aktivacija"] = $config->aktivacija;

    $database->dbclose();
    echo json_encode($postavke);

?>