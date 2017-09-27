<?php

    require ("biblioteka.php");
    session_timeout();

    $flag_ime = false;
    $flag_prezime = false;
    $flag_broj = false;

    $ime = $_GET["ime"];
    $prezime = $_GET["prezime"];
    $broj = $_GET["broj"];
    $dual = $_GET["dual"];
    $id = $_SESSION["id"];

    $database = new Baza();
    $database->dbconnect();

    $regex = "/^[A-ZŠĐČĆŽ][A-ZŠĐČĆŽa-zđčćšž\- ]*[a-zđčćšž]$/";

    if($ime !== ""){
        if(strlen($ime) >= 2 && strlen($ime) <= 50){
            if(preg_match($regex, $ime)){
                $flag_ime = true;
            }
        }
    }

    if($prezime !== ""){
        if(strlen($prezime) >= 2 && strlen($prezime) <= 50){
            if(preg_match($regex, $prezime)){
                $flag_prezime = true;
            }
        }
    }

    if($broj !== ""){
        if(strlen($broj) >= 8 && strlen($broj) <= 20){
            $regex_long = "/^[+][0-9]{1,3} [0-9]{2} [0-9]{3} [0-9]{3,4}$/";
            $regex_short = "/^[0-9]{3} [0-9]{3} [0-9]{3,4}$/";

            if(preg_match($regex_long, $broj) || preg_match($regex_short, $broj)){
                $flag_broj = true;
            }
        }
    }

    if($flag_ime && $flag_prezime && $flag_broj){
        $statement = $database->veza->prepare("UPDATE korisnik SET ime = ?, prezime = ?, mobitel = ?, dual_login = ? WHERE id_korisnik = ?");
        $statement->bind_param("ssssi", $ime, $prezime, $broj, $dual, $id);
        $statement->execute();
        $statement->close();

        dodaj_dnevnik(NULL,"Promjena profila","Ostale radnje",$_SESSION["id"]);
        echo json_encode("success");
    }
    else{
        echo json_encode("error");
    }

    $database->dbclose();
    
?>