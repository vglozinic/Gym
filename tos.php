<?php
    require("biblioteka.php");
    provjeri_sesiju();

    if(isset($_COOKIE["Uvjeti"])){
        header("Location: index.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST) && $_POST["Prihvacam"]) {
            setcookie("Uvjeti", true, time() + 60 * 60 * 24 * 3);
            header("Location: index.php");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Uvjeti korištenja</title>
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
                    UVJETI KORIŠTENJA
                </div>
                
                <div id="menu"> 
                     <ul>
                        <li><a href="index.php">Početna</a></li>
                        <li><a href="registracija.php">Registracija</a></li>
                        <li><a href="prijava.php">Prijava</a></li>
                        <li><a href="o_autoru.php">O autoru</a></li>
                        <li><a href="dokumentacija.php">Dokumentacija</a></li>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <h2>Uvjeti korištenja</h2>
                    <p class="ravnomjerno">
                        Ova aplikacija je izrađena u edukacijske svrhe. 
                        Aplikacija je završni projekt iz kolegija Web dizajn i programiranje
                        na Fakultetu Organizacije i Informatike u Varaždinu.
                        Kao takva ne smije se zlouporabiti ili kopirati bez dopuštenja vlasnika,
                        te je takva zaštićena akademskom licencom.
                    </p>
                    <p class="ravnomjerno">
                        Prihvaćanjem uvjeta korištenja obavezujete se da ćete koristiti aplikaciju
                        u dobroj volji, poštovat ćete pravila i nećete raditi ništa što bi
                        ugrozilo sigurnost ove aplikacije. Osim ovih uvjeta, prihvaćate spremanje
                        kolačića (eng. cookie) na svoje računalo i potvrđujete da ćete koristiti
                        ispravne osobne podatke u radu aplikacije.
                        Za prihvaćanje kliknite na gumb "Prihvaćam". 
                    </p>
                    <form id="forma_tos" name="form_tos" method="post" novalidate>
                        <input class="gumb" type="submit" name="Prihvacam" value="Prihvaćam">
                    </form>

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