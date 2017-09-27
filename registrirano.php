<?php

    require("biblioteka.php");
    provjeri_uvjete();
    provjeri_sesiju();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script type="text/javascript" src="js/datum.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    REGISTRIRAJTE SE
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul> 
                     <hr>
                </div>

                <div id="content">
                    
                    <br>
                    Aktivacijski link vam je poslan na e-mail i vrijedi 5 sati. Kliknite ga kako bi završili registraciju.
                    <br><br>
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