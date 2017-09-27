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

    $statement = $database->veza->prepare("SELECT id_korisnik, email, aktivacijski_kod, vrijeme FROM korisnik WHERE aktivacijski_kod = ? AND aktivan='NE'");
    $statement->bind_param("s", $kod);
    $statement->execute();
    $statement->store_result();

	if(!is_null($statement) && $statement->num_rows > 0){

		$statement->bind_result($id, $email, $aktivacijski_kod, $vrijeme);
        $statement->fetch();

        $now = strtotime(date("Y-m-d H:i:s" , time() + pomak()));
        $vr = strtotime($vrijeme);

        $postavke = postavke();
        $aktivacija = $postavke->aktivacija;

        if(($now - $vr) <= (3600 * intval($aktivacija))){
            $statement = $database->veza->prepare("UPDATE korisnik SET aktivan='DA' where aktivacijski_kod= ?");
            $statement->bind_param("s", $kod);
            $statement->execute();

            dodaj_dnevnik(NULL,"Aktivacija računa","Ostale radnje",$id);
            mail($email, "Aktivacija računa", "Aktivacija računa je uspješno napravljena!", "From: WebDiP2016x043");

            $poruka = "Uspješno ste se registrirali! Kliknite <a href=\"prijava.php\">ovdje</a> kako bi se prijavili u aplikaciju.";
            setcookie("Uvjeti", true, $vr + 60 * 60 * 24 * 30);
        }
        else{
            $poruka = "Link za aktivaciju je istekao. Kliknite <a href=\"ponovno_poslano.php?link=" . $aktivacijski_kod . "\">ovdje</a> kako bi se poslao opet.";
        }
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
                        <?php navigacija(); ?>
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