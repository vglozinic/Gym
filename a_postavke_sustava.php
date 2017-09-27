<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(3);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Postavke sustava</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/postavke_sustava.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    POSTAVKE SUSTAVA
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <div id="error_status"></div>

                    <div class="div_reg">
                        <label for="sesija"><span class="podebljano">Trajanje sesije</span></label>
                        <br>
                        <input id="sat" class="input" name="Sat" type="text" style="width: 40px;"> h :
                        <input id="minuta" class="input" name="Minuta" type="text" style="width: 40px;"> m :
                        <input id="sekunda" class="input" name"Sekunda" type="text" style="width: 40px;"> s 
                        <div id="error_sat"></div>
                        <div id="error_minuta"></div>
                        <div id="error_sekunda"></div>
                    </div>

                    <br>

                    <div class="div_reg">
                        <label for="bnp"><span class="podebljano">Broj neuspješnih prijava</span></label>
                        <br>
                        <select id="bnp" name="BNP" class="input">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                        </select>
                    </div>

                    <br>

                    <div class="div_reg">
                        <label for="stranicenje"><span class="podebljano">Broj zapisa po stranici</span></label>
                        <br>
                        <select id="stranicenje" name="Stranicenje" class="input">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="70">70</option>
                                <option value="80">80</option>
                                <option value="90">90</option>
                                <option value="100">100</option>
                        </select>
                    </div>

                    <br>

                    <label for="aktivacija"><span class="podebljano">Trajanje aktivacije u satima</span></label>
                    <br>
                    <input id="aktivacija" class="input" name="Aktivacija" type="text" size="1">
                    <div id="error_aktivacija"></div>

                    <br>

                    <button class="gumb" id="spremi" type="button">Spremi postavke</button>
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