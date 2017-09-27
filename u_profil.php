<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(1);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Moj profil</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/profil.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    MOJI PODACI
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <div id="error_status"></div>
                    <div id="profil"></div>

                    <div class="div_pro">
                        <label for="ime"> <span class="podebljano">Ime:</span> </label>
                        <br>
                        <input class="input" type="text" id="ime" name="Ime" size="8">
                    </div>

                    <div class="div_pro">
                        <label for="prezime"> <span class="podebljano">Prezime:</span> </label>
                        <br>
                        <input class="input" type="text" id="prezime" name="Prezime" size="8">
                    </div>
                    <div id="error_ime"></div>
                    <div id="error_prezime"></div>

                    <label for="broj"> <span class="podebljano">Broj mobitela:</span> </label>
                    <br>
                    <input class="input" type="text" id="broj" name="Broj">
                    <br>
                    <div id="error_broj"></div>
                    

                    <label for="dual"> <span class="podebljano">Dvostruka prijava:</span> </label>
                    <select id="dual" name="Dual">
                        <option value="DA">Da</option>
                        <option value="NE">Ne</option>
                    </select>
                    <br>

                    <button class="gumb" id="spremi" type="button">Spremi</button>
                    <a href="u_promjena_lozinke.php"><button class="gumb" id="lozinka" type="button">Promjena lozinke</button></a>

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