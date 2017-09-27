<?php

    require ("biblioteka.php");
    session_timeout();

    $database = new Baza();
    $database->dbconnect();

    $termin = "";
    if(isset($_GET["termin"])){
        $termin = $_GET["termin"];
    }
    $program = $_GET["program"];
    $zamijeni = $_GET["zamijeni"];

    $od = $_GET["od"];
    $do = $_GET["do"];
    $dan = $_GET["dan"];

    if($zamijeni === "DA"){
        $upit = "UPDATE termin SET aktivan = 'NE' WHERE id_termin = " . $termin . ";";
        $rezultat = $database->dbselect($upit);

        $upit = "SELECT od, do, dan FROM termin WHERE id_termin = " . $termin . ";";
        $rezultat = $database->dbselect($upit);
        $chanman = $rezultat->fetch_object();

        $upit = "SELECT naziv FROM program WHERE id_program = " . $program . ";";
        $rezultat = $database->dbselect($upit);
        $naziv = $rezultat->fetch_object();

        $upit = "SELECT k.email FROM polaznik p INNER JOIN korisnik k ON k.id_korisnik = p.id_korisnik WHERE p.aktivan = 'DA' AND p.id_program = " . $program . ";";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($email) = $rezultat->fetch_array()) {
                $poruka = "Poštovani, programu " . $naziv->naziv . " termin " . $chanman->dan . " od " . $chanman->od . ":00 do " . $chanman->do . ":00 zamijenio se za termin " . $dan . " od " . $od . ":00 do " . $do . ":00.";
                mail($email, "Promjena termina", $poruka, "From: WebDiP2016x043");
            }
        }
    }
    $upit = "INSERT INTO termin VALUES (NULL, '" . $dan . "', " . $od . ", " . $do . ", 'DA', " . $program . ");";
    $rezultat = $database->dbselect($upit);

    echo json_encode("success");
    $database->dbclose();

?>