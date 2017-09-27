<?php

    require ("baza_class.php");
    
    $korisnici = Array();

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT ime, prezime, username, email, lozinka, naziv FROM korisnik JOIN uloga ON uloga.id_uloga = korisnik.id_uloga ORDER BY id_korisnik ASC;";
    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        $out = "[";
        while (list($ime, $prezime, $username, $email, $lozinka, $naziv) = $rezultat->fetch_array()) {
            $korisnici[] = 
            '{"ime": "' . 
            $ime . 
            '", "prezime": "' . 
            $prezime . 
            '", "username": "' . 
            $username . 
            '", "email": "' . 
            $email . 
            '", "lozinka": "' . 
            $lozinka . 
            '", "naziv": "' . 
            $naziv . 
            ' "}';
        }
        $out .= join(",", $korisnici);
        $out .= "]";
    }

    $database->dbclose();
    echo $out;

?>