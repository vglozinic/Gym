<?php

    require("biblioteka.php");
    provjeri_uvjete();
    provjeri_sesiju();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Zaboravljena lozinka?</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/zaboravljena_lozinka.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    ZABORAVLJENA LOZINKA?
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <div id="error_status">Za novu lozinku upišite svoje korisničko ime.</div>
                    <label class="label_prijava" for="username"><span class="podebljano">Korisničko ime</span></label>
                    <br>
                    <input id="username" class="input_prijava" name="Username" type="text">
                    <br>
                    <div class="div_prijava" id="error_username"></div>
                
                    <button class="gumb margin_top" id="posalji" type="button">Pošalji novu lozinku</button>
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