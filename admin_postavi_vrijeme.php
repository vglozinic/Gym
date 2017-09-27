<?php
    
    require ("biblioteka.php");
    session_timeout();
	$pomak = $_GET["pomak"];

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("UPDATE config SET pomak = ?");
    $statement->bind_param("i", $pomak);
    $uspjeh = $statement->execute();
    $statement->close();

    $database->dbclose();
    echo json_encode($pomak);
?>