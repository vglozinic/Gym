<?php

	require ("baza_class.php");

    $username = $_GET["username"];
    $out = "";

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("SELECT username FROM korisnik WHERE username = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $statement->store_result();

    if($statement->num_rows > 0){
        $out = "taken";
    }

    $statement->close();
    $database->dbclose();
    echo json_encode($out);

?>