<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(1);

    dodaj_dnevnik(NULL,"Pregled kupona","Ostale radnje",$_SESSION["id"]);
    dodaj_bodove("Pregled kupona", 20, $_SESSION["id"], $_SESSION["uloga"]);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dostupni kuponi</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/pregled_kupona.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    DOSTUPNI KUPONI
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Kuponi dostupni za kupnju</h2>
                    <div id="select">
                        <select id="program" name="Program" class="input"></select>
                    </div>
                    <div id="error_status"></div>
                    <div id="galerija">

                    </div>
                    <a href="u_kosarica.php"><button class="gumb" id="kosarica" type="button">Košarica</button></a>
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