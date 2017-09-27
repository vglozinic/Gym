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
        <script type="text/javascript" src="js/moderatori.js"></script>
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
                    <h2>Pregled moderatora po vrsti</h2>
                    <select id="vrsta" name="Vrsta" class="input"></select>
                    <div id="tablica_moderatori" class="tablica">

                    </div>
                    <a href="a_dodaj_moderatora.php"><button class="gumb margin_top" id="dodaj" type="button">Dodaj</button></a>&nbsp;&nbsp;
                    <a href="a_dodijeli_moderatora.php"><button class="gumb margin_top" id="dodijeli" type="button">Dodijeli</button></a>&nbsp;&nbsp;
                    <a href="a_zamijeni_moderatora.php"><button class="gumb margin_top" id="zamijeni" type="button">Zamijeni</button></a>&nbsp;&nbsp;
                    <a href="a_ukloni_moderatora.php"><button class="gumb margin_top" id="ukloni" type="button">Ukloni</button></a>&nbsp;&nbsp;
                    <a href="a_makni_ovlasti.php"><button class="gumb margin_top" id="makni" type="button">Makni</button></a>
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