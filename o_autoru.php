<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>O autoru</title>
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
                    INFORMACIJE O AUTORU
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <h2>Vedran Gložinić</h2>
                    <figure>
                        <img src="slike/portret.jpg">
                        <figcaption>Portret autora</figcaption>
                    </figure>
                    <span class="podebljano">Broj indeksa: </span>41895/13-R<br>
                    <span class="podebljano">E-mail: </span><a href="mailto:vedglozin@foi.hr">vedglozin@foi.hr</a><br>
                    <p class="ravnomjerno margin_top">
                        Vedran Gložinić rođen je i odrastao u Varaždinu, gdje trenutno prebiva. 
                        Od malena se zanimao za računala, pa se zbog toga odlučio baviti informatikom.
                        Srednju školu završio je u Varaždinu, i trenutno studira na Fakultetu Organizacije i Informatike.
                        Tijekom srednje škole osvojio je prvo mjesto na državnom natjecanju iz multimedije održano u Čakovcu,
                        a Elektrostrojarsku školu završio je kao jedan od u generaciji.
                    </p>
                    <p class="ravnomjerno">
                        U slobodno vrijeme bavi se sviranjem, multimedijom i dizajnom. 
                        Osim toga, bavi se i streličarstvom.
                        Glavna stvar osim fakulteta mu je 3D modeliranje, s kojim se u budućnosti želi baviti.
                        Nove ideje uvijek mu se motaju po glavi, te smatra da su kreativnost i marljivost jedne od najboljih vrlina koje posjeduje.
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