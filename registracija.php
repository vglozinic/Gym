<?php

    require("biblioteka.php");
    provjeri_uvjete();
    provjeri_sesiju();

    $error_ime = "";
    $error_prezime = "";
    $error_username = "";
    $error_email = "";
    $error_lozinka = "";
    $error_potvrda = "";
    $error_datum = "";
    $error_broj = "";
    $error_captcha = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $flag_OK = false;
        $flag_ime = false;
        $flag_prezime = false;
        $flag_username = false;
        $flag_email = false;
        $flag_lozinka = false;
        $flag_potvrda = false;
        $flag_datum = false;
        $flag_broj = false;
        $flag_captcha = false;

        $ime = $_POST["Ime"];
        $prezime = $_POST["Prezime"];
        $username = $_POST["Username"];
        $email = $_POST["Email"];
        $lozinka = $_POST["Lozinka"];
        $potvrda = $_POST["Potvrda"];
        $datum = $_POST["Datum"];
        $broj = $_POST["Broj"];
        $spol = $_POST["Spol"];
        if($_POST["Dual"]==="NE"){
            $dual = "NE";
        }
        else{
            $dual = "DA";
        }

        if($ime !== ""){
            if(strlen($ime) >= 2 && strlen($ime) <= 50){

                $regex = "/^[A-ZŠĐČĆŽ][A-ZŠĐČĆŽa-zđčćšž\- ]*[a-zđčćšž]$/";
                if(preg_match($regex, $ime)){
                    $flag_ime = true;
                }
                else{
                    $regex = "/[a-zđčćšž]/";
                    if(preg_match($regex, $ime[strlen($ime)-1])){
                        $error_ime = "Ime mora početi s velikim slovom i može sadržavati slova, razmak i crticu!";
                    }
                    else{
                        $error_ime = "Zadnji znak imena mora biti malo slovo!";
                    }
                }
            }
            else{
                $error_ime = "Ime mora biti između 2 i 50 znakova!";
            }
        }
        else{
            $error_ime = "Ime nije uneseno!";
        }

        if($prezime !== ""){
            if(strlen($prezime) >= 2 && strlen($prezime) <= 50){
                $regex = "/^[A-ZŠĐČĆŽ][A-ZŠĐČĆŽa-zđčćšž\- ]*[a-zđčćšž]$/";
                if(preg_match($regex, $prezime)){
                    $flag_prezime = true;
                }
                else{
                    $regex = "/[a-zđčćšž]/";
                    if(preg_match($regex, $prezime[strlen($prezime)-1])){
                        $error_prezime = "Prezime mora početi s velikim slovom i može sadržavati slova, razmak i crticu!";
                    }
                    else{
                        $error_prezime = "Zadnji znak prezimena mora biti malo slovo!";
                    }
                }
            }
            else{
                $error_prezime = "Prezime mora biti između 2 i 50 znakova!";
            }
        }
        else{
            $error_prezime = "Prezme nije uneseno!";
        }

        $database = new Baza();
        $database->dbconnect();

        if($username !== ""){
            if(strlen($username) >= 8 && strlen($username) <= 25){
                $regex = "/^[a-z0-9][a-z0-9.\-_]*[a-z0-9]$/";
                if(preg_match($regex, $username)){

                    $statement = $database->veza->prepare("SELECT username FROM korisnik WHERE username = ?");
                    $statement->bind_param("s", $username);
                    $statement->execute();
                    $statement->store_result();

                    if($statement->num_rows == 0){
                        $flag_username = true;
                    }
                    else{
                        $error_username = "Korisničko ime je zauzeto!";
                    }

                    $statement->close();
                }
                else{
                    $regex = "/[a-z0-9]/";
                    if(preg_match($regex, $username[0]) && preg_match($regex, $username[strlen($username)-1])){
                        $error_username = "Korisničko ime može sadržavati mala slova, brojke, crticu, točku i podvlaku!";
                    }
                    else{
                        $error_username = "Korisničko ime mora počinjati i završavati malim slovom ili brojkom!";
                    }
                }
            }
            else{
                $error_username = "Korisničko ime mora biti između 8 i 25 znakova!";
            }
        }
        else{
            $error_username = "Korisničko ime nije uneseno!";
        }

        if($email !== ""){
            if(strlen($email) >= 8 && strlen($email) <= 50){
                $regex = "/^[A-Za-z0-9]+[A-Za-z0-9._\-]+@[A-Za-z0-9]+[A-Za-z0-9._\-]+\.[a-z]{2,3}$/";
                if(preg_match($regex, $email)){

                    $statement = $database->veza->prepare("SELECT email FROM korisnik WHERE email = ?");
                    $statement->bind_param("s", $email);
                    $statement->execute();
                    $statement->store_result();

                    if($statement->num_rows == 0){
                        $flag_email = true;
                    }
                    else{
                        $error_email = "E-mail je zauzet!";
                    }

                    $statement->close();

                }
                else{
                    $error_email = "E-mail nije u dobrom obliku! (npr. username@host.domain)";
                }
            }
            else{
                $error_email = "E-mail mora biti između 8 i 50 znakova!";
            }

        }
        else{
            $error_email = "E-mail nije unesen!";
        }

        if($lozinka !== ""){
            if(strlen($lozinka) >= 8 && strlen($lozinka) <= 50){

                $regex = "/^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/";
                if(preg_match($regex, $lozinka)){
                    $flag_lozinka = true;
                }
                else{
                    $regex = "/[A-Za-z0-9]/";
                    if(preg_match($regex, $lozinka[0]) && preg_match($regex, $lozinka[strlen($lozinka)-1])){
                        $error_lozinka = "Lozinka može sadržavati mala i velika slova, brojke, podvlaku i crticu!";
                    }
                    else{
                        $error_lozinka = "Lozinka mora počinjati i završavati slovom ili brojkom!";
                    }
                }
            }
            else{
                $error_lozinka = "Lozinka mora biti između 8 i 50 znakova!";
            }
        }
        else{
            $error_lozinka = "Lozinka nije unesena!";
        }

        if($potvrda !== ""){
            if($potvrda === $lozinka){
                $flag_potvrda = true;
            }
            else{
                $error_potvrda = "Potvrda lozinke se razlikuje od lozinke!";
            }
        }
        else{
            $error_potvrda = "Potvrda lozinke nije unesena!";
        }

        if($datum !== ""){

            $regex = "/^[0123][0-9]\.[01][0-9]\.[0-9]{4}\.$/";

            if(preg_match($regex, $datum)){
                $date = date("Y-m-d", strtotime(substr($datum,0,strlen($datum)-1)));
                $dan = intval(substr($datum, 0, 2));
                $mjesec = intval(substr($datum, 3, 5));
                $godina = intval(substr($datum, 6, 10));

                if(checkdate($mjesec, $dan, $godina)){
                    
                    $today = date_create(date("Y-m-d", time() + pomak()));
                    $diff=date_diff(date_create($date),$today);
                    $today = intval(date("Y", time() + pomak()));

                    if(intval($diff->format("%a")) > (6570 + intval(($today - $godina)/4))){
                        $flag_datum = true;
                    }
                    else{
                        $error_datum = "Niste punoljetni kako bi koristili aplikaciju!";
                    }
                }
                else{
                    $error_datum = "Datum nije ispravan!";
                }
            }
            else{
                $error_datum = "Datum nije u ispravnom formatu! (npr. 28.04.1994.)";
            }
        }
        else{
            $error_datum = "Datum rođenja nije unesen!";
        }

        if($broj !== ""){
            if(strlen($broj) >= 8 && strlen($broj) <= 20){

                $regex_long = "/^[+][0-9]{1,3} [0-9]{2} [0-9]{3} [0-9]{3,4}$/";
                $regex_short = "/^[0-9]{3} [0-9]{3} [0-9]{3,4}$/";

                if(preg_match($regex_long, $broj) || preg_match($regex_short, $broj)){
                    $flag_broj = true;
                }
                else{
                    $error_broj = "Broj nije u ispravnom obliku! (npr. +385 91 234 5678 ili 091 234 5678)";
                }
            }
            else{
                $error_broj = "Broj mobitela mora biti između 8 i 20 znakova!";
            }
        }
        else{
            $error_broj = "Broj mobitela nije unesen!";
        }

        if($_POST["g-recaptcha-response"] == "") {
            $error_captcha = "Captcha nije označena!";
        }
        else {
            $flag_captcha = true;
        }

        if($flag_ime && $flag_prezime && $flag_username && $flag_email && $flag_lozinka && $flag_potvrda && $flag_datum && $flag_broj && $flag_captcha) {
            $flag_OK = true;
        }

        if($flag_OK){

            $dstring = date("Y-m-d H:i:s", time() + pomak());
            $aktivacija = sha1($dstring . $username);
            $hash = hash("sha256",($lozinka . $username));
            $dob = date("Y-m-d", strtotime(substr($datum,0,strlen($datum)-1)));

            $statement = $database->veza->prepare("INSERT INTO korisnik VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, 'NE', 'NE', 500, 1)");
            $statement->bind_param("ssssssssssss", $ime, $prezime, $username, $email, $spol, $broj, $dob, $lozinka, $hash, $dual, $aktivacija, $dstring);
            $statement->execute();
            $statement->close();

            $upit = "SELECT id_korisnik FROM korisnik WHERE vrijeme = '" . $dstring . "';";
            $rezultat = $database->dbselect($upit);
            $id = $rezultat->fetch_object();

            dodaj_dnevnik(NULL,"Registracija","Ostale radnje",$id->id_korisnik);

            $informacija = "Za aktiviranje korisničkog računa kliknite na http://barka.foi.hr/WebDiP/2016_projekti/WebDiP2016x043/aktivacija.php?link=" . $aktivacija;

            mail($email, "Aktivacija računa", $informacija, "From: WebDiP2016x043");
            header("Location: registrirano.php");
        }

        $database->dbclose();
    }
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registracija</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/registracija.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    REGISTRIRAJTE SE
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">

                    <form id="regform" name="reforma" method="post" novalidate>

                        <div class="div_reg">
                            <label for="ime"> <span class="podebljano">Ime:</span> </label>
                            <br>
                            <input class="input" type="text" id="ime" name="Ime" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($ime); }?>">
                            <div id="error_ime"><?php echo $error_ime; ?></div>
                        </div>

                        <div class="div_reg">
                            <label for="prezime"> <span class="podebljano">Prezime:</span> </label>
                            <br>
                            <input class="input" type="text" id="prezime" name="Prezime" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($prezime); }?>">
                            <div id="error_prezime"><?php echo $error_prezime; ?></div>
                        </div>

                        <br>

                        <div class="div_reg">
                            <label for="username"> <span class="podebljano">Korisničko ime:</span> </label>
                            <br>
                            <input class="input" type="text" id="username" name="Username" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($username); }?>">
                            <div id="error_username"><?php echo $error_username; ?></div>
                        </div>

                        <div class="div_reg">
                            <label for="email"> <span class="podebljano">E-mail:</span> </label>
                            <br>
                            <input class="input" type="text" id="email" name="Email" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($email); }?>">
                            <div id="error_email"><?php echo $error_email; ?></div>
                        </div>

                        <br>

                        <div class="div_reg">
                            <label for="lozinka"> <span class="podebljano">Lozinka:</span> </label>
                            <br>
                            <input class="input" type="password" id="lozinka" name="Lozinka" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($lozinka); }?>">
                            <div id="error_lozinka"><?php echo $error_lozinka; ?></div>
                        </div>

                        <div class="div_reg">
                            <label for="potvrda"> <span class="podebljano">Potvrda lozinke:</span> </label>
                            <br>
                            <input class="input" type="password" id="potvrda" name="Potvrda" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($potvrda); }?>">
                            <div id="error_potvrda"><?php echo $error_potvrda; ?></div>
                        </div>

                        <br>

                        <div class="div_reg">
                            <label for="datum"> <span class="podebljano">Datum rođenja:</span> </label>
                            <br>
                            <input class="input" type="text" id="datum" name="Datum" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($datum); }?>">
                            <div id="error_datum"><?php echo $error_datum; ?></div>
                        </div>

                        <div class="div_reg">
                            <label for="broj"> <span class="podebljano">Broj mobitela:</span> </label>
                            <br>
                            <input class="input" type="text" id="broj" name="Broj" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($broj); }?>">
                            <div id="error_broj"><?php echo $error_broj; ?></div>
                        </div>

                        <br>


                        <label for="spol"> <span class="podebljano">Spol:</span> </label>
                        <select id="spol" name="Spol">
                                <option value="M" selected>Muški</option>
                                <option value="F">Ženski</option>
                        </select>

                        <br>

                        <label for="dual"> <span class="podebljano">Dvostruka prijava:</span> </label>
                        <input class="radiobutton" type="radio" value="DA" name="Dual">Da
                        <input class="radiobutton" type="radio" value="NE" name="Dual" checked>Ne
                        <span id="footnote" class="podebljano"> <a>?</a> </span>
                        <div id="div_footnote">
                            Prijava u dva koraka omogućuje veću sigurnost kod prijave.<br>
                            Na e-mail se šalje jedinstveni kod uz kojeg se prijavljujete.
                        </div>

                        <div id="div_captcha">
                            <div class="g-recaptcha" data-sitekey="6LdRTR8UAAAAAOBIiIUzuaTMYQyHpf_Fd25-U1pT" data-callback="correctCaptcha"></div>
                            <div id="error_captcha"><?php echo $error_captcha; ?></div>
                        </div>

                        <input id="submit" class="gumb" type="submit" value="Registriraj se">

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