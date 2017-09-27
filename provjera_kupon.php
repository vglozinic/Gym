<?php

	require ("baza_class.php");

    $kupon = $_GET["kupon"];
    $out = "";

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("SELECT naziv FROM kupon WHERE naziv = ?");
    $statement->bind_param("s", $kupon);
    $statement->execute();
    $statement->store_result();
    
    if($statement->num_rows > 0){
        $out = "exists";
    }

    $statement->close();
    $database->dbclose();
    echo json_encode($out);

?>