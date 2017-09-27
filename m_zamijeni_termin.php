<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(2);

    if(!isset($_GET["id_program"]) || $_GET["id_program"] === "" || !isset($_GET["naziv"]) || $_GET["naziv"] === "" || !isset($_GET["id_termin"]) || $_GET["id_termin"] === ""){
        header("Location: m_termini.php");
    }
    else{
        $database = new Baza();
        $database->dbconnect();

        $statement = $database->veza->prepare("SELECT dan, od, do FROM termin WHERE id_termin = ? AND aktivan = 'DA'");
        $statement->bind_param("i", intval($_GET["id_termin"]));
        $statement->execute();
        $statement->store_result();

        $statement->bind_result($dan, $od, $do);
        $statement->fetch();

        $naziv = $dan . " - " . $od . ":00 do " . $do . ":00"; 

        $statement->close();
        $database->dbclose();
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
        <script type="text/javascript" src="js/zamijeni_termin.js"></script>
        <script>
            var id_program = <?php echo $_GET["id_program"]; ?>;
            var id_termin = <?php echo $_GET["id_termin"]; ?>;
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
                    <h2>Zamjena termina</h2>
                    <div id="error_status"></div>
                    <span class="podebljano">Program: </span>
                    <?php echo $_GET["naziv"]; ?>
                    <br>
                    <span class="podebljano">Termin: </span>
                    <?php echo $naziv; ?>
                    <br>
                    <span class="podebljano">Vrijeme održavanja:</span><br>
                    <select id="od" name="Od" class="input">
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                    </select>
                    h - 
                    <select id="do" name="Do" class="input">
                        <option value="09">09</option>
                        <option value="10" selected>10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                    h
                    <br>
                    <span class="podebljano">Dan:</span>
                    <select id="dan" name="Dan" class="input">
                        <option value="Ponedjeljak">Ponedjeljak</option>
                        <option value="Utorak">Utorak</option>
                        <option value="Srijeda">Srijeda</option>
                        <option value="Četvrtak">Četvrtak</option>
                        <option value="Petak">Petak</option>
                    </select>
                    <br>
                    <button class="gumb margin_top" id="zamijeni" type="button">Zamijeni</button>
                    <a href="m_termini.php"><button class="gumb margin_top" type="button">Natrag</button></a>
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