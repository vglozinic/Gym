<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(1);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Skupljanje bodova</title>
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
                    SKUPLJANJE BODOVA
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Kako se skupljanju bodovi?</h2>
                    <p class="ravnomjerno">
                        Za određene radnje u aplikaciji možete skupiti bodove koje možete koristiti u kupnji kupona popusta.
                        Kuponi imaju svoju cijenu u bodovima, te su dostupni samo za programe vježbanja koje pohađate.
                        Tokom registracije dobivate 500 bodova, a ostale radnje koje donose bodove su:<br>
                    <span class="podebljano">Prijava </span>- Jednom na dan dobivate 50 bodova za prijavu u aplikaciju<br>
                    <span class="podebljano">Prijava u program </span>- Za svaki program vježbanja u koji se prijavite dobivate 100 bodova<br>
                    <span class="podebljano">Pregled programa </span>- Jednom na dan dobivate 20 bodova za pregled svih dostupnih programa vježbanja<br>
                    <span class="podebljano">Pregled kupona </span>- Jednom na dan dobivate 20 bodova za pregled svih aktivnih kupona u prodaji<br>
                    <span class="podebljano">Uspješna kupnja </span>- Kao povrat bodova za svaku uspješnu kupnju kupona dobivate 100 bodova<br>
                    Kupone popusta nakon kupnje možete isprintati te donjeti na blagajnu kako bi ostvarili popust za određeni program.
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