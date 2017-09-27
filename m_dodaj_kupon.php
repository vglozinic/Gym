<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(2);

    if(!isset($_GET["id"]) || $_GET["id"] === ""){
        header("Location: m_kuponi.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Termini programa</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/definiranje.js"></script>
        <script>
            var id = <?php echo $_GET["id"]; ?>;
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
                    TERMINI PROGRAMA
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Definiranje kupona za program</h2>
                    <div id="error_status"></div>
                    <span class="podebljano">Program vježbanja:</span>
                    <br>
                    <select id="program" name="Program" class="input"></select>
                    <div id="block">
                        <span class="podebljano">Kupon popusta:</span>
                        <br>
                        <select id="kupon" name="Kupon" class="input"></select>
                        <br>

                        <div class="div_pro">
                            <label for="od"> <span class="podebljano">Vrijedi od:</span> </label>
                            <br>
                            <input class="input" type="text" id="od" name="Od" size="8">
                        </div>

                        <div class="div_pro">
                            <label for="do"> <span class="podebljano">Vrijedi do:</span> </label>
                            <br>
                            <input class="input" type="text" id="do" name="Do" size="8">
                        </div>
                        
                        <div id="error_od"></div>
                        <div id="error_do"></div>

                        <span class="podebljano"> Bodova potrebno: </span>
                        <input class="input" type="text" id="broj" size="4">
                        <br>
                        <div id="error_broj"></div>

                        <button class="gumb margin_top" id="spremi" type="button">Definiraj</button>
                        <a href="m_kuponi.php"><button class="gumb margin_top" type="button">Natrag</button></a>
                    </div>
                    <div id="error_kupon"></div>
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