<?php

    require ("biblioteka.php");
    session_timeout();
    
    $kod = "";
    if(isset($_GET["kod"])){
        $kod = $_GET["kod"];
    }

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT korisnik.ime, korisnik.prezime, 
            program.naziv AS program, program.mjesec, program.godina, 
            kupon.naziv AS kupon, 
            popust.potrebno, 
            kosarica.kod, kosarica.datum
            FROM kosarica
            INNER JOIN korisnik ON korisnik.id_korisnik = kosarica.id_korisnik
            INNER JOIN popust ON popust.id_popust = kosarica.id_popust
            INNER JOIN kupon ON kupon.id_kupon = popust.id_kupon
            INNER JOIN program ON program.id_program = popust.id_program
            WHERE kod = '" . $kod . "';";

    $rezultat = $database->dbselect($upit);
    $kupon = $rezultat->fetch_object();

    echo json_encode($kupon);
    $database->dbclose();
    

?>