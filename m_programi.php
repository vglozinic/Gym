<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(2);

    dodaj_dnevnik(NULL,"Pregled programa","Ostale radnje",$_SESSION["id"]);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Moji programi</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/programi.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    MOJI PROGRAMI
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Pregled programa</h2>
                    <div id="select">
                        <select id="program" name="Program" class="input"></select>
                    </div>
                    <div id="odabir">
                        <label> Izvodi se: </label>
                        <input class="radiobutton" type="radio" value="DA" name="Dual" checked>Da
                        <input class="radiobutton" type="radio" value="NE" name="Dual">Ne
                    </div>
                    <div id="opis">
                        
                    </div>
                    <div id="gumbi">
                        <a href="m_dodaj_program.php"><button class="gumb margin_top" id="novi" type="button">Novi</button></a>
                        <button class="gumb margin_top" id="otkazi" type="button">Otkaži</button>
                    </div>
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