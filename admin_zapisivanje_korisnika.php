<?php

    require ("biblioteka.php");
    session_timeout();

    $flag_email = false;
    $flag_broj = false;

    $id = $_POST["id"];
    $email = $_POST["email"];
    $dual = $_POST["dual"];
    $aktivan = $_POST["aktivan"];
    $broj = $_POST["broj"];

    $database = new Baza();
    $database->dbconnect();

    if($email !== ""){
        if(strlen($email) >= 8 && strlen($email) <= 50){

            $regex = "/^[A-Za-z0-9]+[A-Za-z0-9._\-]+@[A-Za-z0-9]+[A-Za-z0-9._\-]+\.[a-z]{2,3}$/";
            if(preg_match($regex, $email)){
                $statement = $database->veza->prepare("SELECT email FROM korisnik WHERE email = ? AND NOT id_korisnik = ?");
                $statement->bind_param("si", $email, $id);
                $statement->execute();
                $statement->store_result();

                if($statement->num_rows == 0){
                    $flag_email = true;
                }
                $statement->close();
            }
        }
    }

    if($broj !== ""){
        $regex = "/^[0-9]+$/";
        if(preg_match($regex, $broj)){
            if(intval($broj) >= 0 && intval($broj) <= 1000000){
                $flag_broj = true;
            }
        }
    }

    if($flag_email && $flag_broj){

        $statement = $database->veza->prepare("UPDATE korisnik SET email = ?, dual_login = ?, aktivan = ?, broj_bodova = ? WHERE id_korisnik = ?");
        $statement->bind_param("sssii", $email, $dual, $aktivan, $broj, $id);
        $statement->execute();
        $statement->close();
        
        echo json_encode("success");
    }
    else{
        echo json_encode("error");
    }

    $database->dbclose();

?>