<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(1);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Košarica</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/kosarica.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    KOŠARICA
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Artikli u košarici</h2>
                    <div id="error_status"></div>
                    <div class="tablica" id="tablica"></div>
                    <div id="gumbi">
                        <button class="gumb margin_top" id="kupi" type="button">Kupi</button>&nbsp;&nbsp;
                        <button class="gumb margin_top" id="osvjezi" type="button">Osvježi</button>
                    </div>
                    <div id="areyousureaboutthat" class="skrij margin_top">
                        Jeste li sigurni da želite kupiti ove kupone?
                        <br>
                        <button class="gumb margin_top" id="da" type="button">Da</button>&nbsp;&nbsp;
                        <button class="gumb margin_top" id="ne" type="button">Ne</button>
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