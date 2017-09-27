<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(3);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Pregled korisnika</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/svi.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    PREGLED KORISNIKA
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <h2>Postavke korisnika aplikacije</h2>
                    <div id="error_status"></div>
                    <select id="korisnik" name="Korisnik" class="input"></select>
                    <br>
                    
                    <label for="email"> <span class="podebljano">E-mail:</span> </label>
                    <br>
                    <input class="input" type="text" id="email" name="Email">
                    <br>
                    <div id="error_email"></div>

                    <span class="podebljano">Dvostruka prijava:</span>
                    <select id="dual" name="Dual">
                        <option value="DA">Da</option>
                        <option value="NE">Ne</option>
                    </select>
                    <br>
                    <span class="podebljano">Korisnik aktiviran:</span>
                    <select id="aktivan" name="Aktivan">
                        <option value="DA">Da</option>
                        <option value="NE">Ne</option>
                    </select>
                    <br>

                    <span class="podebljano">Stanje bodova: </span>
                    <input class="input" type="text" id="broj" size="4">
                    <br>
                    <div id="error_broj"></div>

                    <button class="gumb margin_top" id="spremi" type="button">Spremi</button>
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