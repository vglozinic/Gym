<?php

    require ("biblioteka.php");
    session_timeout();

    $flag_do = false;
    $flag_od = false;
    $flag_potrebno = false;

    $database = new Baza();
    $database->dbconnect();

    dodaj_dnevnik(NULL,"Definiranje kupona","Ostale radnje",$_SESSION["id"]);

    $od = $_GET["od"];
    $do = $_GET["do"];
    $potrebno = $_GET["broj"];
    $program = $_GET["program"];
    $kupon = $_GET["kupon"];

    $upit = "SELECT * FROM popust WHERE id_program = " . $program . " AND id_kupon = " . $kupon . ";";
    $rezultat = $database->dbselect($upit);

    $regex = "/^[0123][0-9]\.[01][0-9]\.[0-9]{4}\.$/";

    if($od !== ""){
        if(preg_match($regex, $od)){
            $date = date("Y-m-d", strtotime(substr($od,0,strlen($od)-1)));
            $dan = intval(substr($od, 0, 2));
            $mjesec = intval(substr($od, 3, 5));
            $godina = intval(substr($od, 6, 10));

            if(checkdate($mjesec,$dan,$godina)){
                $flag_od = true;
            }
        }
    }

    if($do !== ""){
        if(preg_match($regex, $do)){
            $date = date("Y-m-d", strtotime(substr($do,0,strlen($do)-1)));
            $dan = intval(substr($do, 0, 2));
            $mjesec = intval(substr($do, 3, 5));
            $godina = intval(substr($do, 6, 10));

            if(checkdate($mjesec,$dan,$godina)){
                $flag_do = true;
            }
        }
    }

    $broj = "/^[0-9]+$/";

    if($potrebno !== ""){
        if(preg_match($broj, $potrebno)){
            if(intval($potrebno) >= 20 && intval($potrebno) <= 20000){
                $flag_potrebno = true;
            }
        }
    }

    if($flag_od && $flag_do && $flag_potrebno){

        $od_datum = date("Y-m-d", strtotime(substr($od,0,strlen($od)-1)));
        $do_datum = date("Y-m-d", strtotime(substr($do,0,strlen($do)-1)));

        if($rezultat->num_rows > 0){
            $statement = $database->veza->prepare("UPDATE popust SET od = ?, do = ?, potrebno = ?, aktivan = 'DA' WHERE id_program = ? AND id_kupon = ?");
            $statement->bind_param("ssiii", $od_datum, $do_datum, $potrebno, $program, $kupon);
            $statement->execute();
        }
        else{
            $statement = $database->veza->prepare("INSERT INTO popust VALUES (NULL, ?, ?, ?, 'DA', ?, ?)");
            $statement->bind_param("issii", $potrebno, $od_datum, $do_datum, $kupon, $program);
            $statement->execute();
        }
        $statement->close();
        echo json_encode("success");
    }
    else{
        echo json_encode("error");
    }

    $database->dbclose();

?>