<?php

    require ("biblioteka.php");
    session_timeout();
    
    $programi = Array();
    if(isset($_GET["program"])){
        $program = $_GET["program"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($_SESSION["uloga"] != 2){
        if($program === "np"){
            $upit = "SELECT id_program, naziv, mjesec, godina, broj_polaznika, broj_mjesta FROM program WHERE aktivan='DA' AND 
            id_program NOT IN (SELECT id_program FROM polaznik WHERE id_korisnik = " . $_SESSION["id"] . ");";

            $rezultat = $database->dbselect($upit);

            if($rezultat->num_rows > 0){
                while (list($id, $naziv, $mjesec, $godina, $bp, $bm) = $rezultat->fetch_array()) {
                    if($bp == $bm){
                        $popunjeno = "DA";
                    }
                    else{
                        $popunjeno = "NE";
                    }
                    array_push($programi, array(
                        "id" =>$id,
                        "naziv" => $naziv,
                        "mjesec" => $mjesec,
                        "godina" => $godina,
                        "popunjeno" => $popunjeno
                    ));
                }
                echo json_encode($programi);
            }
            else{
                echo json_encode("empty");
            }
        }
        else{
            $upit = "SELECT DISTINCT(p.id_program), p.naziv, p.mjesec, p.godina, l.zabranjen
            FROM polaznik l INNER JOIN program p ON p.id_program = l.id_program
            WHERE l.id_korisnik = " . $_SESSION["id"] . " AND l.aktivan = 'DA';";

            $rezultat = $database->dbselect($upit);

            if($rezultat->num_rows > 0){
                while (list($id, $naziv, $mjesec, $godina, $zabranjen) = $rezultat->fetch_array()) {
                    array_push($programi, array(
                        "id" =>$id,
                        "naziv" => $naziv,
                        "mjesec" => $mjesec,
                        "godina" => $godina,
                        "zabranjen" => $zabranjen
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