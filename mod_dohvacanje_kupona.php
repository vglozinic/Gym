<?php

    require ("biblioteka.php");
    session_timeout();
    
    $kuponi = Array();

    $exists = "";
    $id = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }
    if(isset($_GET["exists"])){
        $exists = $_GET["exists"];
    }

    $database = new Baza();
    $database->dbconnect();

    if($exists === "DA"){
        $upit = "SELECT k.id_kupon, k.naziv, k.pdf_putanja, k.slika_putanja, k.video_putanja, p.od, p.do, p.potrebno
                FROM kupon k INNER JOIN popust p 
                ON p.id_kupon = k.id_kupon 
                WHERE id_program = " . $id . " AND aktivan = 'DA';";

        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($id, $naziv, $pdf, $slika, $video, $od, $do, $potrebno) = $rezultat->fetch_array()) {
                array_push($kuponi, array(
                    "id" => $id,
                    "naziv" => $naziv,
                    "pdf" => $pdf,
                    "slika" => $slika,
                    "video" => $video,
                    "od" => $od,
                    "do" => $do,
                    "potrebno" => $potrebno
                ));
            }
            echo json_encode($kuponi);
        }
        else{
            echo json_encode("none");
        }
    }
    else{
        $upit = "SELECT id_kupon, naziv FROM kupon WHERE id_kupon NOT IN (SELECT k.id_kupon
            FROM kupon k INNER JOIN popust p 
            ON p.id_kupon = k.id_kupon 
            WHERE id_program = " . $id . " AND aktivan = 'DA');";

        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            while (list($id, $naziv) = $rezultat->fetch_array()) {
                array_push($kuponi, array(
                    "id" => $id,
                    "naziv" => $naziv
                ));
            }
            echo json_encode($kuponi);
        }
        else{
            echo json_encode("none");
        }
    }
    
    $database->dbclose();
    
?>