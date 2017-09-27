<?php

    require ("biblioteka.php");
    session_timeout();

    $locked = "";
    $programi = Array();
    if(isset($_GET["locked"])){
        $locked = $_GET["locked"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($_SESSION["uloga"] == 2){

        if($locked === "NE"){
            $upit = "SELECT DISTINCT(p.id_program), p.naziv, p.mjesec, p.godina FROM program p
                    INNER JOIN trener t ON t.id_trener = p.id_trener
                    INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
                    INNER JOIN polaznik l ON l.id_program = p.id_program
                    WHERE p.aktivan = 'DA' AND t.id_korisnik = " . $_SESSION["id"] . " AND l.aktivan = 'DA';";

            $rezultat = $database->dbselect($upit);
            if($rezultat->num_rows > 0){
                while (list($id, $naziv, $mjesec, $godina) = $rezultat->fetch_array()) {
                    array_push($programi, array(
                        "id" =>$id,
                        "naziv" => $naziv,
                        "mjesec" => $mjesec,
                        "godina" => $godina
                    ));
                }
                echo json_encode($programi);
            }
            else{
                echo json_encode("empty");
            }
        }
        else{
            $upit = "SELECT DISTINCT(p.id_program), p.naziv, p.mjesec, p.godina FROM program p
                    INNER JOIN trener t ON t.id_trener = p.id_trener
                    INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
                    INNER JOIN polaznik l ON l.id_program = p.id_program
                    WHERE p.aktivan = 'DA' AND t.id_korisnik = " . $_SESSION["id"] . " AND l.zabranjen = 'DA';";

            $rezultat = $database->dbselect($upit);
            if($rezultat->num_rows > 0){
                while (list($id, $naziv, $mjesec, $godina) = $rezultat->fetch_array()) {
                    array_push($programi, array(
                        "id" =>$id,
                        "naziv" => $naziv,
                        "mjesec" => $mjesec,
                        "godina" => $godina
                    ));
                }
                echo json_encode($programi);
            }
            else{
                echo json_encode("empty");
            }
        }
        
    }

    if($_SESSION["uloga"] == 3){

        if($locked === "NE"){
            $upit = "SELECT DISTINCT(p.id_program), p.naziv, p.mjesec, p.godina FROM program p
                INNER JOIN trener t ON t.id_trener = p.id_trener
                INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
                INNER JOIN polaznik l ON l.id_program = p.id_program
                WHERE p.aktivan = 'DA' AND l.aktivan = 'DA';";

            $rezultat = $database->dbselect($upit);
            if($rezultat->num_rows > 0){
                while (list($id, $naziv, $mjesec, $godina) = $rezultat->fetch_array()) {
                    array_push($programi, array(
                        "id" =>$id,
                        "naziv" => $naziv,
                        "mjesec" => $mjesec,
                        "godina" => $godina
                    ));
                }
                echo json_encode($programi);
            }
            else{
                echo json_encode("empty");
            }
        }
        else{
            $upit = "SELECT DISTINCT(p.id_program), p.naziv, p.mjesec, p.godina FROM program p
                    INNER JOIN trener t ON t.id_trener = p.id_trener
                    INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
                    INNER JOIN polaznik l ON l.id_program = p.id_program
                    WHERE p.aktivan = 'DA' AND l.zabranjen = 'DA';";

            $rezultat = $database->dbselect($upit);
            if($rezultat->num_rows > 0){
                while (list($id, $naziv, $mjesec, $godina) = $rezultat->fetch_array()) {
                    array_push($programi, array(
                        "id" =>$id,
                        "naziv" => $naziv,
                        "mjesec" => $mjesec,
                        "godina" => $godina
                    ));
                }
                echo json_encode($programi);
            }
            else{
                echo json_encode("empty");
            }
        }
        
    }
    
    $database->dbclose();
    

?>