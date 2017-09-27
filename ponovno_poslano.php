<?php

    require("biblioteka.php");
    provjeri_uvjete();
    provjeri_sesiju();

    $kod="";
    $poruka = "";
    if(!empty($_GET["link"])){
		$kod = $_GET["link"];
	}

    $database = new Baza();
	$database->dbconnect();

    $statement = $database->veza->prepare("SELECT id_korisnik, username, email FROM korisnik WHERE aktivacijski_kod = ? AND aktivan='NE'");
    $statement->bind_param("s", $kod);
    $statement->execute();
    $statement->store_result();

    if(!is_null($statement) && $statement->num_rows > 0){

        $statement->bind_result($id, $username, $email);
        $statement->fetch();

        $vrijeme = date("Y-m-d H:i:s", time() + pomak());
        $aktivacija = sha1($vrijeme . $username);

        $statement = $database->veza->prepare("UPDATE korisnik SET aktivacijski_kod = ?, vrijeme = ? WHERE id_korisnik = ?");
        $statement->bind_param("ssi", $aktivacija, $vrijeme, $id);
        $statement->execute();

        $informacija = "Za aktiviranje korisničkog računa kliknite na http://barka.foi.hr/WebDiP/2016_projekti/WebDiP2016x043/aktivacija.php?link=" . $aktivacija;
        $poruka = "Kod je ponovo poslan na e-mail i vrijedi 5 sati.";
        mail($email, "Aktivacija računa", $informacija, "From: WebDiP2016x043");
    }
    else{
        header("Location: index.php");
    }

    $statement->close();
    $database->dbclose();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Aktivacija</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
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
                    REGISTRIRAJTE SE
                </div>

                <div id="menu">
                     <ul>
                        <li><a href="index.php">Početna</a></li>
                        <li><a href="registracija.php"><span class="current">Registracija</span></a></li>
                        <li><a href="prijava.php">Prijava</a></li>
                        <li><a href="o_autoru.php">O autoru</a></li>
                        <li><a href="dokumentacija.php">Dokumentacija</a></li>
                     </ul>
                     <hr>
                </div>

                <div id="content">
                    
                    <br>
                    <?php echo $poruka; ?>
                    <br><br>
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