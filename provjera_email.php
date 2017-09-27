<?php

	require ("baza_class.php");

    $email = $_GET["email"];
    $out = "";

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("SELECT email FROM korisnik WHERE email = ?");
    $statement->bind_param("s", $email);
    $statement->execute();
    $statement->store_result();
    
    if($statement->num_rows > 0){
        $out = "taken";
    }

    $statement->close();
    $database->dbclose();
    echo json_encode($out);

?>