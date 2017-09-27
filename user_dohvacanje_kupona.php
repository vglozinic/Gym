<?php

    require ("biblioteka.php");
    session_timeout();
    
    $id = "";
    $flag = true;
    $kuponi = Array();
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT p.id_popust, k.naziv, k.pdf_putanja, k.slika_putanja, k.video_putanja, p.od, p.do, p.potrebno 
             FROM popust p INNER JOIN kupon k ON p.id_kupon = k.id_kupon
             WHERE p.id_program = " . $id . " AND p.aktivan = 'DA' AND p.potrebno < " . stanje_bodova() . ";";

    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){

        while (list($id, $naziv, $opis, $slika, $video, $od, $do, $broj) = $rezultat->fetch_array()) {
            $flag = true;
            $now = strtotime(date("Y-m-d H:i:s" , time() + pomak()));

            for($i = 0; $i < count($_SESSION["kosarica"]); $i++){
                if($id == $_SESSION["kosarica"][$i]["id"]){
                    $flag = false;
                }
            }
            if($flag){
                if(($now >= strtotime($od)) && ($now <= strtotime($do))){
                    array_push($kuponi, array(
                        "id" =>$id,
                        "naziv" => $naziv,
                        "opis" => $opis,
                        "slika" => $slika,
                        "video" => $video,
                        "od" => $od,
                        "do" => $do,
                        "broj" => $broj
                    )); 
                }
            }
        }
        if(empty($kuponi)){
            echo json_encode("empty");
        }
        else{
            echo json_encode($kuponi);
        } 
    }
    else{
        echo json_encode("empty");
    }  

    $database->dbclose();
    
?>