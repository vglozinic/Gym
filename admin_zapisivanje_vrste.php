<?php

    require ("biblioteka.php");
    session_timeout();

    $success = "success";
    $naziv = $_GET["naziv"];

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("INSERT INTO vrsta VALUES (NULL, ?)");
    $statement->bind_param("s", $naziv);
    $statement->execute();

    $statement->close();
    $database->dbclose();
    echo json_encode($success);

?>