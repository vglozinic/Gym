<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(3);
    $config = postavke();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dnevnik sustava</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/dnevnik.js"></script>
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
                    DNEVNIK SUSTAVA
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <h2>Dnevnik sustava</h2>
                    <div id="gumb">
                        <button class="gumb pushed" id="pretrazivanje" type="button">Sortiranje</button>
                        <button class="gumb" id="frekvencija" type="button">Frekvencija</button>
                    </div>
                    <div id="div_pretrazivanje">
                        Pretraga po tipu radnje: 
                        <select id="tip" name="Tip" class="input">
                            <option value="All">Sve</option>
                        </select>
                        <br>
                        Pretraga po korisniku: 
                        <select id="korisnik" name="Korisnik" class="input">
                            <option value="all">Svi</option>
                        </select>
                        <br>
                        Sortiranje po vremenu: 
                        <select id="order" name="Order" class="input">
                            <option value="ASC">Uzlazno</option>
                            <option value="DESC">Silazno</option>
                        </select>
                        <div class="tablica" id="tablica_pretrazivanje"></div>
                        <br>
                        <div id="stranicenje_pretrazivanje"></div>
                    </div>
                    <div id="div_frekvencija" class="skrij">
                        Sortiranje po frekvenciji: <select id="freq" name="Order" class="input">
                        <option value="DESC">Veća prema manjoj</option>
                        <option value="ASC">Manja prema većoj</option>
                        </select>
                        <div class="tablica" id="tablica_frekvencija"></div>
                        <br>
                        <div id="stranicenje_frekvencija"></div>
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