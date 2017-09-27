<?php

    require("biblioteka.php");

    provjeri_uvjete();
    session_timeout();
    provjeri_ulogu(3);

    $error_naziv = "";
    $error_opis = "";
    $error_slika = "";
    $error_video = "";
    $error_status = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $flag_naziv = false;
        $flag_opis = false;
        $flag_slika = false;
        $flag_video = false;

        $dir_opis = "kuponi/pdf/";
        $dir_slika = "kuponi/img/";
        $dir_video = "kuponi/video/";

        $naziv = $_POST["Naziv"];

        $database = new Baza();
        $database->dbconnect();

        if($naziv !== ""){
            if(strlen($naziv) <= 100){

                $regex = "/^[A-ZŠĐŽĆČ][A-ZŠĐŽĆČa-zšđžćč0-9%\-!.,* ]*$/";
                if(preg_match($regex, $naziv)){

                    $statement = $database->veza->prepare("SELECT naziv FROM kupon WHERE naziv = ?");
                    $statement->bind_param("s", $naziv);
                    $statement->execute();
                    $statement->store_result();
                    
                    if($statement->num_rows > 0){
                        $error_naziv = "Kupon ovog naziva već postoji!";
                    }
                    else{
                        $error_naziv = "";
                        $flag_naziv = true;
                    }
                }
                else{
                    $regex = "/[A-ZŠĐŽĆČ]/";

                    if(preg_match($regex, $naziv[0])){
                        $error_naziv = "Naziv mora sadržavati slova, brojke i specijalne znakove (% - ! . , *)!";
                    }
                    else{
                        $error_naziv = "Naziv mora početi s velikim slovom!";
                    }
                }
            }
            else{
                 $error_naziv = "Naziv ne smije biti veći od 100 znakova!";
            }
        }
        else{
            $error_naziv = "Naziv kupona nije unesen!";
        }

        if ($_FILES["Opis"]["error"] == 1) {
            $error_opis = "Datoteka prekoračuje serversku veličinu!";
        }
        else {
            if ($_FILES["Opis"]["error"] != 4) {
                $mimetype = mime_content_type($_FILES["Opis"]["tmp_name"]);
                if ($mimetype == "application/pdf") {
                    if (file_exists($dir_opis . $_FILES["Opis"]["name"])) {
                        $error_opis = "Dokument ovog imena već postoji!";
                    }
                    else {
                        if ($_FILES["Opis"]["size"] > 1048576) {
                            $error_opis = "Odabrani dokument je veći od 1MB!";
                        }
                        else {
                            $flag_opis = true;
                        }
                    }
                }
                else {
                    $error_opis  = "Datoteka nije u PDF formatu!";
                }
            }
            else{
                $error_opis = "Datoteka za prijenos nije odabrana!";
            }
        }

        if ($_FILES["Slika"]["error"] == 1) {
            $error_slika = "Datoteka prekoračuje serversku veličinu!";
        }
        else {
            if ($_FILES["Slika"]["error"] != 4) {
                $mimetype = mime_content_type($_FILES["Slika"]["tmp_name"]);
                if ($mimetype == "image/png" || $mimetype == "image/jpeg") {
                    if (file_exists($dir_slika . $_FILES["Slika"]["name"])) {
                        $error_slika = "Slika s ovim imenom već postoji!";
                    }
                    else {
                        if ($_FILES["Slika"]["size"] > 524288) {
                            $error_slika = "Odabrana slika je veća od 512KB!";
                        }
                        else {
                            $flag_slika = true;
                        }
                    }
                }
                else {
                    $error_slika  = "Datoteka nije u dobrom formatu!";
                }
            }
            else{
                $error_slika = "Datoteka za prijenos nije odabrana!";
            }
        }

        if ($_FILES["Video"]["error"] == 1) {
            $error_video = "Datoteka prekoračuje serversku veličinu!";
        }
        else {
            if ($_FILES["Video"]["error"] != 4) {
                $mimetype = mime_content_type($_FILES["Video"]["tmp_name"]);
                if ($mimetype == "video/mp4") {
                    if (file_exists($dir_video . $_FILES["Video"]["name"])) {
                        $error_video = "Video s ovim imenom već postoji!";
                        $flag_video = false;
                    }
                    else {
                        if ($_FILES["Video"]["size"] > 2097152) {
                            $flag_video = false;
                            $error_video = "Odabrani video je veći od 2MB!";
                        }
                        else {
                            $flag_video = true;
                        }
                    }
                }
                else {
                    $flag_video = false;
                    $error_video  = "Datoteka nije u MP4 formatu!";
                }
            }
            else{
                $flag_video = true;
            }
        }

        if ($flag_naziv && $flag_opis && $flag_slika && $flag_video) {
            
            $baza_opis = $dir_opis . $_FILES["Opis"]["name"];
            $baza_slika = $dir_slika . $_FILES["Slika"]["name"];
            if($_FILES["Video"]["error"] != 4){
                $baza_video = $dir_video . $_FILES["Video"]["name"];
            }
            else{
                $baza_video = null;
            }

            $statement = $database->veza->prepare("INSERT INTO kupon VALUES (NULL, ?, ?, ?, ?)");
            $statement->bind_param("ssss", $naziv, $baza_opis, $baza_slika, $baza_video);
            $statement->execute();
            $statement->close();

            if (!move_uploaded_file($_FILES["Opis"]["tmp_name"], $dir_opis . $_FILES["Opis"]["name"])) {
                $error_opis = "Dogodila se greška kod prijenosa dokumenta!";
            }
            if (!move_uploaded_file($_FILES["Slika"]["tmp_name"], $dir_slika . $_FILES["Slika"]["name"])) {
                $error_slika = "Dogodila se greška kod prijenosa slike!";
            }
            if($_FILES["Video"]["error"] != 4){
                if (!move_uploaded_file($_FILES["Video"]["tmp_name"], $dir_opis . $_FILES["Video"]["name"])) {
                    $error_video = "Dogodila se greška kod prijenosa videa!";
                }
            }     

            $error_status = "Kupon je uspješno stvoren!";
        }

        $database->dbclose();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dodavanje kupona</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/datum.js"></script>
        <script type="text/javascript" src="js/dodaj_kupon.js"></script>
    </head>

    <body>
        <div id="stretcher">
            <div id="container">
                <div id="logo">
                    <img src="slike/logo.png">
                </div>

                <div id="information"></div>

                <div id="header">
                    KUPONI POPUSTA
                </div>

                <div id="menu">
                     <ul>
                        <?php navigacija(); ?>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    <h2>Dodavanje kupona</h2>
                    <form enctype="multipart/form-data" id="kupform" name="kuforma" method="post" novalidate>
                        <div id="error_status"><?php echo $error_status; ?></div>

                        <label for="naziv"> <span class="podebljano">Naziv:</span> </label>
                        <br>
                        <input class="input" type="text" id="naziv" name="Naziv" value="<?php if($_SERVER["REQUEST_METHOD"] == "POST"){ echo htmlspecialchars($naziv); }?>">
                        <br>
                        <div id="error_naziv"><?php echo $error_naziv; ?></div>

                        <label for="opis"> <span class="podebljano">Opis u PDF formatu:</span> </label>
                        <br>
                        <input type="file" id="opis" name="Opis" class="input upload">
                        <br>
                        <div id="error_opis"><?php echo $error_opis; ?></div>

                        <label for="slika"> <span class="podebljano">Slika (.jpg, .png):</span> </label>
                        <br>
                        <input type="file" id="slika" name="Slika" class="input upload">
                        <br>
                        <div id="error_slika"><?php echo $error_slika; ?></div>

                        <label for="video"> <span class="podebljano">Video (.mp4 format):</span> </label>
                        <br>
                        <input type="file" id="video" name="Video" class="input upload">
                        <br>
                        <div id="error_video"><?php echo $error_video; ?></div>

                        <input id="submit" class="gumb margin_top" type="submit" value="Spremi">
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