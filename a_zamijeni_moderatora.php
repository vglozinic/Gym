<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(3);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pregled moderatora</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/zamijeni_moderatora.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    MODERATORI
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <h2>Zamijeni moderatora</h2>
                    <div id="error_status"></div>
                    <label class="label_prijava" for="program"><span class="podebljano">Program</span></label>
                    <br>
                    <select id="program" name="Program" class="input"></select>
                    <div id="error_program"></div>
                    Program se izvodi: 
                    <input class="radiobutton" type="radio" value="DA" name="Aktivan" checked>Da
                    <input class="radiobutton" type="radio" value="NE" name="Aktivan">Ne
                    <br>
                    <label class="label_prijava" for="moderator"><span class="podebljano">Moderator</span></label>
                    <br>
                    <select id="moderator" name="Moderator" class="input"></select>
                    <br>
                    <a href="a_moderatori.php"><button class="gumb margin_top">Natrag</button></a>
                    <button class="gumb margin_top" id="zamijeni" type="button">Zamijeni</button>
                    <button class="gumb margin_top" id="zamijeni_sve" type="button">Zamijeni sve</button>
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