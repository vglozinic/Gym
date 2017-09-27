<?php

    require("biblioteka.php");
    session_start();
    if (isset($_SESSION["id"])) {
        dodaj_dnevnik(NULL,"Odjava","Prijava i odjava",$_SESSION["id"]);

        session_unset();
        session_destroy();
    }
    header("Location: prijava.php");
    
?>