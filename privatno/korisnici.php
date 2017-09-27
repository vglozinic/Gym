<?php

    require("../biblioteka.php");
    provjeri_uvjete();
    session_timeout();

    if(isset($_SERVER["HTTPS"])){
        if(!empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] === "on"){
            header("Location: http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
            exit();
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Ispis korisnika .htaccess</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../js/datum.js"></script>
        <script type="text/javascript" src="../js/korisnici.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="../slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    HTACCESS ISPIS KORISNIKA
                </div>
                
                <div id="menu"> 
                     <ul>
                        <li><a href="../index.php">Početna</a></li>
                        <li><a href="../o_autoru.php">O autoru</a></li>
                        <li><a href="../dokumentacija.php">Dokumentacija</a></li>
                        <li><a href="korisnici.php">Korisnici</a></li>
                        <?php 
                            if(isset($_SESSION["id"])){
                                echo "<li><a href=\"../odjava.php\">Odjava</a></li>";
                            }
                        ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    
                </div>   

                <div id="footer">
                    <hr>
                    <a href="mailto:vedglozin@foi.hr">VEDRAN GLOŽINIĆ</a> - SVA PRAVA PRIDRŽANA, 2017
                    <br>
                </div>        
            </div>
        </div>
    </body>
</html>