<?php

    require ("biblioteka.php");
    session_timeout();

    $database = new Baza();
    $database->dbconnect();

    $flag_naziv = false;
    $flag_opis = false;
    $flag_program = false;
    
    $naziv = $_POST["naziv"];
    $opis = $_POST["opis"];
    $mjesec = $_POST["mjesec"];
    $godina = $_POST["godina"];
    $broj = $_POST["broj"];

    $vrsta = $_POST["vrsta"];
    $korisnik = $_SESSION["id"];

    $regex = "/^[A-ZŠĐČĆŽ0-9][A-Z0-9ŠĐČĆŽa-zđčćšž\-+:. ]*[A-Z0-9a-zđčćšž]$/";
    if($naziv !== "" && (strlen($naziv) <= 100) && preg_match($regex, $naziv)){
        $flag_naziv = true;
    }

    $regex = "/^[A-ZŠĐČĆŽ][A-Z0-9ŠĐČĆŽa-zđčćšž,. ]*[.]$/";
    if($opis !== "" && (strlen($opis) <= 100) && preg_match($regex, $opis)){
        $flag_opis = true;
    }

    $upit = "SELECT id_program FROM program WHERE naziv = '" . $naziv . "' AND mjesec = " . $mjesec . " AND godina = " . $godina . ";";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $flag_program = false;
    }
    else{
        $flag_program = true;
    }

    if($flag_naziv && $flag_opis && $flag_program){

        $upit = "SELECT id_trener FROM trener WHERE id_vrsta = " . $vrsta . " AND id_korisnik = " . $korisnik . ";";
        $rezultat = $database->dbselect($upit);
        $trener = $rezultat->fetch_object();

        $statement = $database->veza->prepare("INSERT INTO program VALUES (NULL, ?, ?, ?, ?, 0, ?, 'DA', ?, ?)");
        $statement->bind_param("ssiiiii", $naziv, $opis, $mjesec, $godina, $broj, $vrsta, $trener->id_trener);
        $statement->execute();
        $statement->close();

        dodaj_dnevnik("INSERT INTO program VALUES (NULL, \"" . $naziv . "\", \"" . $opis . "\", " . $mjesec . ", " . $godina . ", 0, " . $broj . ", \"DA\", " . $vrsta . ", " . $trener->id_trener . ");",NULL,"Rad s bazom",$korisnik);

        $upit = "SELECT id_program, naziv FROM program WHERE naziv = '" . $naziv . "' AND mjesec = " . $mjesec . " AND godina = " . $godina . ";";
        $rezultat = $database->dbselect($upit);
        $program = $rezultat->fetch_object();

        echo json_encode((string)$program->id_program . "&naziv=" . (string)$program->naziv);
    }
    else{
        echo json_encode("error");
    }
    
    $database->dbclose();

?>