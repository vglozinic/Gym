<?php

    require("biblioteka.php");
    //( ͡° ͜ʖ ͡°)

    provjeri_uvjete();
    session_timeout();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Početna</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
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
                    WEB APLIKACIJA TERETANA
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <h2>Dobrodošli u web aplikaciju Teretana!</h2>
                    <p class="ravnomjerno">
                        Aplikacija Teretana omogućuje prijave na programe za trening 
                        i praćenje evidencije dolazaka i napredovanja.
                        Ona je namijenjena svima koji žele jednostavno i učinkovito 
                        pratiti svoj napredak i postići odlične rezultate kao učinak
                        svojeg treninga. 
                    </p>
                    <p class="ravnomjerno">
                        Neregistrirani korisnici dužni su se registrirati koristeći
                        prave informacije kako bi pristupili elementima sustava.
                        Ako se ne registrirate, možete vidjeti samo najviše posjećene
                        programe po vrstama.
                    </p>
                    <p class="ravnomjerno">
                        Registrirani korisnici imaju mogućnost prijavljivanja na programe
                        i praćenje evidencije dolazaka. Oni mogu skupljati bodove koji
                        se mogu zamijeniti za kupone popusta. Kod plaćanje svojeg programa
                        u teretani možete predočiti kupon te tako ostvarujete popust na postotak
                        koji je određen kuponom. 
                    </p>
                    <p class="ravnomjerno">
                        Ako se još niste registrirali kliknite <a href="registracija.php">ovdje</a>, 
                        a ako ste registrirani i želite 
                        se prijaviti kliknite <a href="prijava.php">ovdje</a>. Ukoliko imate
                        bilo kakvih problema kontaktirajte našeg administratora na 
                        <a href="mailto:vedglozin@foi.hr">vedgloin@foi.hr</a>.
                    </p>
                    <p class="ravnomjerno">
                        Nadamo se da će vam ova aplikacija olakšati evidenciju dolazaka i pomoći
                        u pohađanju programa u našoj teretani!
                    </p>

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