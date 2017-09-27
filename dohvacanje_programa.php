<?php

    require ("biblioteka.php");
    session_timeout();
    
    $id = $_GET["id"];
    $programi = Array();

    $database = new Baza();
    $database->dbconnect();

    $upit = "SELECT COUNT(*) as broj_dolazaka, p.naziv, p.opis, p.mjesec, p.godina, p.aktivan
    FROM program p
    INNER JOIN termin t ON p.id_program = t.id_program
    INNER JOIN evidencija e ON e.id_termin = t.id_termin
    INNER JOIN vrsta v ON p.id_vrsta = v.id_vrsta
    WHERE e.prisutan = 'DA'
    AND p.id_vrsta = " . $id . "
    GROUP BY p.id_program
    ORDER BY 1 DESC
    LIMIT 0, 3";

    $rezultat = $database->dbselect($upit);

    if($rezultat->num_rows > 0){
        while (list($broj_dolazaka, $naziv, $opis, $mjesec, $godina, $aktivan) = $rezultat->fetch_array()) {
            array_push($programi, array(
                "naziv" => $naziv, 
                "broj_dolazaka" => $broj_dolazaka, 
                "godina" => $godina, 
                "aktivan" => $aktivan, 
                "mjesec" => $mjesec,
                "opis" => $opis
                ));
        }
    }

    $database->dbclose();
    echo json_encode($programi);

?>