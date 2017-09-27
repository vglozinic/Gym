<?php

	require ("biblioteka.php");
    session_timeout();

    $id = $_GET["id"];
    $email = $_GET["email"];
    $out = "";

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("SELECT email FROM korisnik WHERE email = ? AND NOT id_korisnik = ?");
    $statement->bind_param("si", $email, $id);
    $statement->execute();
    $statement->store_result();
    
    if($statement->num_rows > 0){
        $out = "taken";
    }

    $statement->close();
    $database->dbclose();
    echo json_encode($out);

?>