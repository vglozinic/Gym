<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(1);
    $config = postavke();

    dodaj_dnevnik(NULL,"Pregled bodova","Ostale radnje",$_SESSION["id"]);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Stanje bodova</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/bodovi.js"></script>
        <script>
            var zapis = <?php echo $config->stranicenje; ?>;
        </script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    STANJE BODOVA
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Skupljeni bodovi</h2>
                    <div id="stanje"></div>
                    Sortiraj po radnjama:
                    <select id="radnja" name="Program" class="input">
                        <option value="All">Sve</option>
                    </select>
                    <br>
                    Sortiranje po datumu: 
                    <select id="order" name="Order" class="input">
                        <option value="DESC">Silazno</option>
                        <option value="ASC">Uzlazno</option>
                    </select>
                    <div class="tablica" id="tablica"></div>
                    <br>
                    <div id="stranicenje"></div>
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