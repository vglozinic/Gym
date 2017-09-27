<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(1);

    $error_lozinka = "";
    $error_nova = "";
    $error_potvrda = "";
    $error_status = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $flag_lozinka = false;
        $flag_potvrda = false;
        $flag_nova = false;

        $lozinka = $_POST["Lozinka"];
        $nova = $_POST["Nova"];
        $potvrda = $_POST["Potvrda"];

        $database = new Baza();
        $database->dbconnect();

        $upit = "SELECT username, encrypted FROM korisnik WHERE id_korisnik = " . $_SESSION["id"] . ";";
        $rezultat = $database->dbselect($upit);
        $korisnik = $rezultat->fetch_object();

        if($lozinka !== ""){
            if(strlen($lozinka) >= 8 && strlen($lozinka) <= 50){

                $regex = "/^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/";
                if(preg_match($regex, $lozinka)){

                    if(hash("sha256", ($lozinka . $korisnik->username)) === $korisnik->encrypted){
                        $flag_lozinka = true;
                    }
                    else{
                        $error_lozinka = "Trenutna lozinka nije ispravna!";
                    }
                }
                else{
                    $regex = "/[A-Za-z0-9]/";
                    if(preg_match($regex, $lozinka[0]) && preg_match($regex, $lozinka[strlen($lozinka)-1])){
                        $error_lozinka = "Trenutna lozinka može sadržavati mala i velika slova, brojke, podvlaku i crticu!";
                    }
                    else{
                        $error_lozinka = "Trenutna lozinka mora počinjati i završavati slovom ili brojkom!";
                    }
                }

            }
            else{
                $error_lozinka = "Trenutna lozinka mora biti između 8 i 50 znakova!";
            }
        }
        else{
            $error_lozinka = "Trenutna lozinka nije unesena!";
        }

        if($nova !== ""){
            if(strlen($nova) >= 8 && strlen($nova) <= 50){

                $regex = "/^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/";
                if(preg_match($regex, $nova)){
                    $flag_nova = true;
                }
                else{
                    $regex = "/[A-Za-z0-9]/";
                    if(preg_match($regex, $nova[0]) && preg_match($regex, $nova[strlen($login_lozinka)-1])){
                        $error_nova = "Nova lozinka može sadržavati mala i velika slova, brojke, podvlaku i crticu!";
                    }
                    else{
                        $error_nova = "Nova lozinka mora počinjati i završavati slovom ili brojkom!";
                    }
                }
            }
            else{
                $error_nova = "Nova lozinka mora biti između 8 i 50 znakova!";
            }
        }
        else{
            $error_nova = "Potvrda nove lozinke nije unesena!";
        }

        if($potvrda !== ""){
            if($potvrda === $nova){
                $flag_potvrda = true;
            }
            else{
                $error_potvrda = "Potvrda nove lozinke nije ispravna!";
            }
        }
        else{
            $error_potvrda = "Potvrda nove lozinke nije unesena!";
        }

        if($flag_lozinka && $flag_nova && $flag_potvrda){

            if($lozinka === $nova){
                $error_status = "Trenutna i nova lozinka su jednake!";
            }
            else{
                $hash = hash("sha256", ($nova. $korisnik->username));
                $id = $_SESSION["id"];

                $statement = $database->veza->prepare("UPDATE korisnik SET lozinka = ?, encrypted = ? WHERE id_korisnik = ?");
                $statement->bind_param("ssi", $nova, $hash, $id);
                $statement->execute();
                $statement->close();

                dodaj_dnevnik(NULL,"Promjena lozinke","Ostale radnje",$_SESSION["id"]);
                header("Location: u_lozinka_promijenjena.php");
            }
        }

        $database->dbclose();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Promjena lozinke</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/lozinka.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    PROMJENA LOZINKE
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <form id="forma_promjena" name="form_promjena" method="post" novalidate>
                        <div id="error_status"><?php echo $error_status; ?></div>

                        <label for="lozinka"><span class="podebljano">Stara lozinka:</span></label>
                        <br>
                        <input id="lozinka" class="input" name="Lozinka" type="password" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($lozinka); } ?>">
                        <br>
                        <div class="div_margin" id="error_lozinka"><?php echo $error_lozinka; ?></div>

                        <label for="nova"><span class="podebljano">Nova lozinka:</span></label>
                        <br>
                        <input id="nova" class="input" name="Nova" type="password" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($nova); } ?>">
                        <br>
                        <div class="div_margin" id="error_nova"><?php echo $error_nova; ?></div>

                        <label for="potvrda"><span class="podebljano">Potvrda lozinke:</span></label>
                        <br>
                        <input id="potvrda" class="input" name="Potvrda" type="password" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($potvrda); } ?>">
                        <br>
                        <div class="div_margin" id="error_potvrda"><?php echo $error_potvrda; ?></div>

                        <input class="gumb" type="submit" value="Promjeni">
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