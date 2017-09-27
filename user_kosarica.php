<?php

    require ("biblioteka.php");
    session_timeout();

    $id = "";
    $radnja = "";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }
    if(isset($_GET["radnja"])){
        $radnja = $_GET["radnja"];
    }

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT p.id_popust, k.naziv AS k_naziv, k.pdf_putanja, k.slika_putanja, k.video_putanja, p.potrebno, m.naziv AS p_naziv FROM popust p 
            INNER JOIN kupon k ON k.id_kupon = p.id_kupon
            INNER JOIN program m ON m.id_program = p.id_program
            WHERE id_popust = " . $id . ";";
    $rezultat = $database->dbselect($upit);
    $kupon = $rezultat->fetch_object();

    if($radnja === "DODAJ"){
        array_push($_SESSION["kosarica"], array(
            "id" => $kupon->id_popust,
            "kupon" => $kupon->k_naziv,
            "opis" => $kupon->pdf_putanja,
            "slika" => $kupon->slika_putanja,
            "video" => $kupon->video_putanja,
            "broj" => intval($kupon->potrebno),
            "program" => $kupon->p_naziv
        ));
    }
    else{
        for($i = 0; $i < count($_SESSION["kosarica"]); $i++){
            if($id == $_SESSION["kosarica"][$i]["id"]){
                array_splice($_SESSION["kosarica"],$i,1);
            }
        }
    }

    echo json_encode("success");
    $database->dbclose();
    
?>