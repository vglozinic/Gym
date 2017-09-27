<?php

	require ("baza_class.php");

    $kod = $_GET["kod"];
    $out = "";

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("SELECT kod FROM kosarica WHERE kod = ?");
    $statement->bind_param("i", $kod);
    $statement->execute();
    $statement->store_result();
    
    if($statement->num_rows > 0){
        $out = "exists";
    }
    else{
        $out = "nope";
    }

    $statement->close();
    $database->dbclose();
    echo json_encode($out);

?>