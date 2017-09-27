<?php

    require ("baza_class.php");

	$username = $_GET["username"];
    $out = "";

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("SELECT aktivan, zabranjen FROM korisnik WHERE username = ?");
    $statement->bind_param("s", $username);
    $statement->execute();
    $statement->store_result();

    if($statement->num_rows > 0){
        $statement->bind_result($aktivan, $zabranjen);
        $statement->fetch();

        $out["aktivan"] = $aktivan;
        $out["zabranjen"] = $zabranjen;
    }
    else {
        $out = "none";
    }

    $statement->close();
    $database->dbclose();
    echo json_encode($out);

?>