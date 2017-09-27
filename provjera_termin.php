<?php

    require ("biblioteka.php");
    session_timeout();

    if (isset($_GET["termin"])) {
        $termin = $_GET["termin"];
    }
    else {
        $termin = null;
    }
    $program = $_GET["program"];
    $od = $_GET["od"];
    $do = $_GET["do"];
    $dan = $_GET["dan"];

    $database = new Baza();
    $database->dbconnect();

    if (is_null($termin)) {
        $upit = "SELECT t.id_termin FROM termin t
                INNER JOIN program p ON p.id_program = t.id_program
                WHERE p.id_vrsta = (SELECT id_vrsta FROM program WHERE id_program = " . $program . ") 
                AND p.godina = (SELECT godina FROM program WHERE id_program = " . $program . ")
                AND p.mjesec = (SELECT mjesec FROM program WHERE id_program = " . $program . ")
                AND t.dan = '" . $dan . "' AND (((" . $od . " > t.od AND " . $od . " < t.do) OR
                 (" . $do . " > t.od AND " . $do . " < t.do)) OR
                 ((" . $od . " = t.od OR " . $od . " = t.do) AND
                 (" . $do . " = t.od OR " . $do . " = t.do)))
                AND t.aktivan = 'DA' AND p.aktivan = 'DA'
                AND p.id_program = t.id_program";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            echo json_encode("exists");
        }
        else{
            echo json_encode("ok");
        }
    }
    else {
        $upit = "SELECT * FROM termin t 
                INNER JOIN program p ON t.id_program = t.id_program
                WHERE p.id_vrsta = (SELECT id_vrsta FROM program WHERE id_program = " . $program . ")
                AND p.godina = (SELECT godina FROM program WHERE id_program = " . $program . ")
                AND p.mjesec = (SELECT mjesec FROM program WHERE id_program = " . $program . ")
                AND t.id_termin <> " . $termin . " AND t.dan = '" . $dan . "'
                AND (((" . $od . " > t.od AND " . $od . " < t.do) OR
                 (" . $do . " > t.od AND " . $do . " < t.do)) OR
                 ((" . $od . " = t.od OR " . $od . " = t.do) AND
                 (" . $do . " = t.od OR " . $do . " = t.do)))
                AND t.aktivan = 'DA' AND p.aktivan = 'DA'
                AND p.id_program = t.id_program";
        $rezultat = $database->dbselect($upit);

        if($rezultat->num_rows > 0){
            echo json_encode("exists");
        }
        else{
            echo json_encode("ok");
        }
    }

    $database->dbclose();

?>