<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(2);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Novi program</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/dodaj_program.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    NOVI PROGRAM
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Pokretanje novog programa vježbanja</h2>

                    <label for="naziv"> <span class="podebljano"> Naziv: </span> </label>
                    <br>
                    <input class="input" type="text" id="naziv">
                    <div id="error_naziv"></div>

                    <label for="opis"> <span class="podebljano"> Opis: </span> </label>
                    <br>
                    <textarea id="opis" rows="4" cols="48" placeholder="Opišite što se radi u ovom terminu u nekoliko rečenica"></textarea> 
                    <div id="error_opis"></div>

                    <label> <span class="podebljano"> Održavanje: </span> </label>
                    <br>
                    <select id="mjesec" name="Mjesec" class="input"></select>
                    <select id="godina" name="Godina" class="input"></select>
                    <br>

                    <label for="broj"> <span class="podebljano"> Broj polaznika: </span> </label>
                    <select id="broj" name="Broj" class="input">
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15" selected>15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>     
                    </select>
                    <br>

                    <label for="vrsta"> <span class="podebljano"> Vrsta: </span> </label>
                    <select id="vrsta" name="Vrsta" class="input"></select>
                    <br>

                    <a href="m_programi.php"><button class="gumb margin_top" id="odustani" type="button">Odustani</button></a>
                    <button class="gumb margin_top" id="pokreni" type="button">Pokreni</button>
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