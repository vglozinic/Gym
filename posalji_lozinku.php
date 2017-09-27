<?php

    require ("biblioteka.php");

    $out = "done";
    $username = "";
    if(!empty($_GET["username"])){
		$username = $_GET["username"];
	}
    else{
        header("Location: index.php");
    }

    $codebook = "AaBbCcDeEeFfGgHhIiJjKkLlMmNnOoPpRrSsTtUuVvZzQqWwYyXx0123456789";
    $random = rand(0,56);
    $lozinka = substr(str_shuffle($codebook), $random, 8);
    $hash = hash("sha256", ($lozinka . $username));

    $database = new Baza();
    $database->dbconnect();

    $statement = $database->veza->prepare("UPDATE korisnik SET lozinka = ?, encrypted = ? WHERE username = ?");
    $statement->bind_param("sss", $lozinka, $hash, $username);
    $statement->execute();
    $statement->store_result();

    $upit = "SELECT id_korisnik, email FROM korisnik WHERE lozinka = '" . $lozinka . "';";
    $rezultat = $database->dbselect($upit);
    $objekt = $rezultat->fetch_object();

    dodaj_dnevnik(NULL,"Generiranje lozinke","Ostale radnje",$objekt->id_korisnik);
    mail($objekt->email, "Nova lozinka", "Nova lozinka za prijavu u sustav je: " . $lozinka, "From: WebDiP2016x043");

    $statement->close();
    $database->dbclose();
    echo json_encode($out);

?>