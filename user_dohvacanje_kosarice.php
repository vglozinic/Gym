<?php

    require ("biblioteka.php");
    session_timeout();

    if(!empty($_SESSION["kosarica"])){
        echo json_encode($_SESSION["kosarica"]);
    }
    else{
        echo json_encode("empty");
    }
    
?>