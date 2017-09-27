<?php

    require("biblioteka.php");
    provjeri_uvjete();
    provjeri_sesiju();
    $korisnik = provjeri_korisnika(); 

    if(empty($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] === "off"){
        header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
        exit();
    }

    $error_status = "";
    $error_username = "";
    $error_lozinka = "";
    $error_kod = "";
    $dual = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $login_username = $_POST["Username"];
        $login_lozinka = $_POST["Lozinka"];

        $flag_username = false;
        $flag_lozinka = false;

        $database = new Baza();
        $database->dbconnect();

        $statement = $database->veza->prepare("SELECT id_korisnik, username, email, encrypted, dual_login, aktivan, zabranjen, krivi_login, broj_bodova, id_uloga FROM korisnik WHERE username = ?");
        $statement->bind_param("s", $login_username);
        $statement->execute();
        $statement->store_result();

        $statement->bind_result($id, $username, $email, $encrypted, $dual_login, $aktivan, $zabranjen, $krivi_login, $broj_bodova, $id_uloga);
        $statement->fetch();

        if($login_username === ""){
            $error_username = "Korisničko ime nije uneseno!";
        }
        else{
            if(strlen($login_username) >= 8 && strlen($login_username) <= 25){

                $regex = "/^[a-z0-9][a-z0-9.\-_]*[a-z0-9]$/";

                if(preg_match($regex, $login_username)){
                    if(!is_null($statement) && $statement->num_rows > 0){
                        if($aktivan === "DA"){
                            if($zabranjen === "NE"){
                                $flag_username = true;
                            }
                            else{
                                $error_status = "Zabranjen vam je pristup. Kontaktirajte administratora.";
                            }
                        }
                        else{
                            $error_status = "Niste aktivirali korisnički račun!";
                        }
                    }
                    else{
                        $error_username = "Korisničko ime ne postoji!";
                    }
                }
                else{
                    $error_username = "Korisničko ime može sadržavati mala slova, brojke, crticu, točku i podvlaku!";
                }
            }
            else{
                $error_username = "Korisničko ime mora biti između 8 i 25 znakova!";
            }
        }

        if($login_lozinka === ""){
            $error_lozinka = "Lozinka nije unesena!";
        }
        else{
            if(strlen($login_lozinka) >= 8 && strlen($login_lozinka) <= 50){

                $regex = "/^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/";
                if(preg_match($regex, $login_lozinka)){
                    $flag_lozinka = true;
                }
                else{
                    $regex = "/[A-Za-z0-9]/";
                    if(preg_match($regex, $login_lozinka[0]) && preg_match($regex, $login_lozinka[strlen($login_lozinka)-1])){
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

        if($flag_username && $flag_lozinka){

            if(hash("sha256",($login_lozinka . $username)) === $encrypted){

                $upit = "UPDATE korisnik SET krivi_login = 0 WHERE id_korisnik = " . $id . ";";
                $database->dbselect($upit);

                if($dual_login === "NE"){

                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;
                    $_SESSION["email"] = $email;
                    $_SESSION["uloga"] = $id_uloga;
                    $_SESSION["bodovi"] = $broj_bodova;
                    $_SESSION["trajanje"] = strtotime(date("Y-m-d H:i:s", time() + pomak()));
                    $_SESSION["kosarica"] = Array();

                    setcookie("Korisnik", $username, time() + 60 * 60 * 24 * 7);

                    dodaj_bodove("Prijava", 50, $_SESSION["id"], $_SESSION["uloga"]);
                    dodaj_dnevnik(NULL,"Uspješna prijava","Prijava i odjava",$id);
                    header("Location: index.php");
                }
                else{

                    $dual = "<label for=\"dual\"><span class=\"podebljano\">Kod za prijavu</span></label><br><input type=\"text\" id=\"kod\" name=\"Kod\" value='" . ( isset($_POST["Kod"]) ? $_POST["Kod"] : "" ) . "'><br><div id=\"error_kod\" class=\"div_margin\">";

                    $upit = "SELECT kod, vrijeme FROM kljuc WHERE id_korisnik = " . $id . " AND aktivan='DA';";
                    $rezultat = $database->dbselect($upit);
                    $kod = $rezultat->fetch_object();

                    if(!is_null($rezultat) && $rezultat->num_rows > 0){

                        $trenutno_vrijeme = strtotime(date("Y-m-d H:i:s", time() + pomak()));
                        $vrijeme_slanja = strtotime($kod->vrijeme);

                        if(($trenutno_vrijeme - $vrijeme_slanja) <= 300){

                            if(isset($_POST["Kod"]) && $_POST["Kod"] != ""){
                                $login_kod = $_POST["Kod"];
                                if($login_kod === $kod->kod){

                                    $error_status = "";

                                    $_SESSION["id"] = $id;
                                    $_SESSION["username"] = $username;
                                    $_SESSION["email"] = $email;
                                    $_SESSION["uloga"] = $id_uloga;
                                    $_SESSION["bodovi"] = $broj_bodova;
                                    $_SESSION["trajanje"] = strtotime(date("Y-m-d H:i:s", time() + pomak()));
                                    $_SESSION["kosarica"] = Array();

                                    setcookie("Korisnik", $username, time() + 60 * 60 * 24 * 30);

                                    $statement = $database->veza->prepare("UPDATE kljuc SET aktivan = 'NE' WHERE kod = ?");
                                    $statement->bind_param("s", $login_kod);
                                    $statement->execute();
                                    $statement->close();

                                    dodaj_bodove("Prijava", 50, $_SESSION["id"], $_SESSION["uloga"]);
                                    dodaj_dnevnik(NULL,"Uspješna prijava","Prijava i odjava",$id);
                                    header("Location: index.php");
                                }
                                else{
                                    $dual .= "Uneseni kod nije valjan!";
                                }
                            }
                        }
                        else{

                            $upit = "UPDATE kljuc SET aktivan = 'NE' WHERE kod = '" . $kod->kod . "';";
                            $database->dbselect($upit);

                            $vrijeme = date("Y-m-d H:i:s", time() + pomak());
                            $codebook = "ABCDEFGHIJKLMNOPRSTUVZQWYX0123456789";
                            $random = rand(0,31);
                            $generirano = substr(str_shuffle($codebook), $random, 5);

                            mail($email, "Kod prijave", "Za prijavu koristite kod " . $generirano, "From: WebDiP2016x043");
                            if(isset($_POST["Kod"]) && $_POST["Kod"] != ""){
                                $error_status = "Uneseni kod je istekao! <br> Na e-mail vam je poslan novi kod.";
                            } 
                            $upit = "INSERT INTO kljuc VALUES (NULL,'" . $generirano . "','" . $vrijeme . "','DA'," . $id . ");";
                            $database->dbselect($upit);
                            
                        }

                    }
                    else{

                        $vrijeme = date("Y-m-d H:i:s", time() + pomak());
                        $codebook = "ABCDEFGHIJKLMNOPRSTUVZQWYX0123456789";
                        $random = rand(0,31);
                        $generirano = substr(str_shuffle($codebook), $random, 5);

                        mail($email, "Kod prijave", "Za prijavu koristite kod " . $generirano, "From: WebDiP2016x043");
                        $error_status = "Na e-mail vam je poslan kod za prijavu.";

                        $upit = "INSERT INTO kljuc VALUES (NULL,'" . $generirano . "','" . $vrijeme . "','DA'," . $id . ");";
                        $database->dbselect($upit);

                    }
                    $dual .= "</div>";    
                }
            }
            else{
                dodaj_dnevnik(NULL,"Neuspješna prijava","Prijava i odjava",$id);

                $postavke = postavke();
                $bnp = $postavke->bnp;

                if(intval($krivi_login) < intval($bnp)){
                    if(intval($krivi_login) === intval($bnp)-1){
                        $upit = "UPDATE korisnik SET krivi_login=krivi_login + 1, zabranjen='DA' WHERE id_korisnik = " . $id . ";";
                        $database->dbselect($upit);
                        $error_status = "Zabranjen vam je pristup. Kontaktirajte administratora.";

                        dodaj_dnevnik(NULL,"Zaključavanje koisnika","Prijava i odjava",$id);
                    }
                    else{
                        $upit = "UPDATE korisnik SET krivi_login=krivi_login + 1 WHERE id_korisnik = " . $id . ";";
                        $database->dbselect($upit);
                        $error_lozinka = "Lozinka nije točna! Imate još " . ((intval($bnp)-1) - intval($krivi_login)) . " pokušaja.";
                    }
                }
            }
        }

        $statement->close();
        $database->dbclose();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Prijava</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/prijava.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    PRIJAVITE SE
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <form id="forma_prijava" name="form_login" method="post" novalidate>
                        <div id="error_status"><?php echo $error_status; ?></div>
                        <label for="username"><span class="podebljano">Korisničko ime</span></label>
                        <br>
                        <input id="username" class="input" name="Username" type="text" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST") { echo htmlspecialchars($login_username); } else { echo htmlspecialchars($korisnik); } ?>">
                        <br>
                        <div class="div_margin" id="error_username"><?php echo $error_username; ?></div>

                        <label for="lozinka"><span class="podebljano">Lozinka</span></label>
                        <br>
                        <input id="lozinka" class="input" name="Lozinka" type="password" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST") { echo htmlspecialchars($login_lozinka); } ?>">
                        <br>
                        <div class="div_margin" id="error_lozinka"><?php echo $error_lozinka; ?></div>

                        <?php echo $dual; ?>

                        <input class="gumb" type="submit" value="Prijavi se">
                        <br>
                        <a href="zaboravljena_lozinka.php">Zaboravili ste lozinku?</a>
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