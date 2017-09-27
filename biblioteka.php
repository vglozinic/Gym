<?php

require("baza_class.php");
$library_database = new Baza();

function provjeri_uvjete() {
    if (!isset($_COOKIE["Uvjeti"])) {
        header("Location: tos.php");
    } 
}

function navigacija(){
    $meni = "";
    if(isset($_SESSION["id"])){
        if($_SESSION["uloga"] == 1 ){
            $meni .= "<li>&nbsp;<a href=\"index.php\">Početna</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"najbolji_programi.php\">Dobri programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_pregled_programa.php\">Programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_pregled_kupona.php\">Kuponi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_moji_programi.php\">Moji programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_bodovi.php\">Stanje bodova</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_povijest_kupnje.php\">Povijest kupnje</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_radnje.php\">Skupljanje bodova</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"privatno/korisnici.php\">Korisnici</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"o_autoru.php\">O autoru</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"dokumentacija.php\"> Dokumentacija </a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_kosarica.php\">Košarica</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_profil.php\">Profil</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"odjava.php\">Odjava</a>&nbsp;</li>";
        }

        if($_SESSION["uloga"] == 2){
            $meni .= "<li>&nbsp;<a href=\"index.php\">Početna</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"najbolji_programi.php\">Dobri programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_povijest_kupnje.php\">Povijest kupnje</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_provjeri_kupon.php\">Provjera kupona</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_kuponi.php\">Kuponi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_programi.php\">Moji programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_termini.php\">Termini</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_polaznici.php\">Polaznici</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"privatno/korisnici.php\">Korisnici</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"o_autoru.php\">O autoru</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"dokumentacija.php\">Dokumentacija</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_profil.php\">Profil</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"odjava.php\">Odjava</a>&nbsp;</li>";
        }

        if($_SESSION["uloga"] == 3){
            $meni .= "<li>&nbsp;<a href=\"index.php\">Početna</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"najbolji_programi.php\">Dobri programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_pregled_programa.php\">Pregled programa</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_moji_programi.php\">Moji programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_provjeri_kupon.php\">Provjera kupona</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_kuponi.php\">Definiranje kupona</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_programi.php\">Programi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_termini.php\">Termini</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"m_polaznici.php\">Polaznici</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_korisnici.php\">Korisnici</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_moderatori.php\">Moderatori</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_kuponi.php\">Kuponi</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_vrste_programa.php\">Vrste programa</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_postavke_sustava.php\">Postavke sustava</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_statistika.php\">Statistika</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_dnevnik.php\">Dnevnik</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_virtualno_vrijeme.php\">Virtualno vrijeme</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_otkljucavanje_korisnika.php\">Otključavanje</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"a_zakljucavanje_korisnika.php\">Zaključavanje</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"privatno/korisnici.php\">Korisnici</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"o_autoru.php\">O autoru</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"dokumentacija.php\">Dokumentacija</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"u_profil.php\">Profil</a>&nbsp;</li>";
            $meni .= "<li>&nbsp;<a href=\"odjava.php\">Odjava</a>&nbsp;</li>";
        }
    }
    else{
        $meni .= "<li>&nbsp;<a href=\"index.php\">Početna</a>&nbsp;</li>";
        $meni .= "<li>&nbsp;<a href=\"najbolji_programi.php\">Dobri programi</a>&nbsp;</li>";
        $meni .= "<li>&nbsp;<a href=\"registracija.php\">Registracija</a>&nbsp;</li>";
        $meni .= "<li>&nbsp;<a href=\"prijava.php\">Prijava</a>&nbsp;</li>";
        $meni .= "<li>&nbsp;<a href=\"privatno/korisnici.php\">Korisnici</a>&nbsp;</li>";
        $meni .= "<li>&nbsp;<a href=\"o_autoru.php\">O autoru</a>&nbsp;</li>";
        $meni .= "<li>&nbsp;<a href=\"dokumentacija.php\">Dokumentacija</a>&nbsp;</li>";
    }
    echo $meni;
}

function provjeri_korisnika(){
    if (!isset($_COOKIE["Korisnik"])) {
        return "";
    } 
    else{
        return $_COOKIE["Korisnik"];
    }
}

function dodaj_bodove($radnja, $bodovi, $id_korisnik, $id_uloga) {
    global $library_database;
    if($id_uloga == 1){
        $library_database->dbconnect();
        $datum = date("Y-m-d", time() + pomak());
        if($radnja == "Prijava" || $radnja == "Pregled programa" || $radnja == "Pregled kupona"){
            $upit = "SELECT * FROM statistika WHERE datum = '" . $datum . "' AND radnja = '" . $radnja . "' AND id_korisnik = " . $id_korisnik . ";";
            $library_rezultat = $library_database->dbselect($upit); 

            if($library_rezultat->num_rows == 0){
                $upit = "INSERT INTO statistika VALUES (NULL, '" . $radnja . "'," . $bodovi . ",'" . $datum . "'," . $id_korisnik . ");";
                $library_database->dbselect($upit);

                $upit = "UPDATE korisnik SET broj_bodova = broj_bodova + " . $bodovi . " WHERE id_korisnik = " . $id_korisnik . ";";
                $library_database->dbselect($upit);
            }
        }
        else{
            $upit = "INSERT INTO statistika VALUES (NULL, '" . $radnja . "'," . $bodovi . ",'" . $datum . "'," . $id_korisnik . ");";
            $library_database->dbselect($upit);

            $upit = "UPDATE korisnik SET broj_bodova = broj_bodova + " . $bodovi . " WHERE id_korisnik = " . $id_korisnik . ";";
            $library_database->dbselect($upit);
        } 
        
        $library_database->dbclose();
        unset($upit);
    } 
}

function dodaj_dnevnik($query, $radnja, $tip_radnje, $id_korisnik) {
    global $library_database;
    $library_database->dbconnect();
    $upit = "INSERT INTO dnevnik VALUES (NULL, ";
    if (is_null($query)) {
        $upit .= "NULL";
    }
    else {
        $upit .= "'" . $query . "'";
    }
    $upit .= ", ";
    if (is_null($radnja)) {
        $upit .= "NULL";
    }
    else {
        $upit .= "'" . $radnja . "'";
    }
    $upit .= ",'" . date("Y-m-d H:i:s", time() + pomak()) . "','" . $tip_radnje . "'," . $id_korisnik . ");";
    $library_database->dbselect($upit);
    $library_database->dbclose();
    unset($upit);
}

function provjeri_ulogu($uloga) {
    if (!isset($_SESSION["uloga"])){
        header("Location: index.php");
    } 
    else {
        if ($_SESSION["uloga"] < $uloga) {
            header("Location: index.php");
        }
    }
}

function stanje_bodova() {
    global $library_database;
    if (isset($_SESSION["bodovi"])){
        $library_database->dbconnect();
        $library_upit = "SELECT broj_bodova FROM korisnik WHERE id_korisnik = " . $_SESSION["id"] . ";";
        $library_rezultat = $library_database->dbselect($library_upit);
        $library_objekt = $library_rezultat->fetch_object();
        $_SESSION["bodovi"] = intval($library_objekt->broj_bodova);
        return intval($library_objekt->broj_bodova);
    } 
}

function provjeri_sesiju(){
    session_start();
    if(isset($_SESSION["id"])){
        header("Location: index.php");
    }
}

function session_timeout(){
    global $library_database;
    session_start();
    if(isset($_SESSION["trajanje"])){
        $library_database->dbconnect();
        $library_upit = "SELECT sesija FROM config";
        $library_rezultat = $library_database->dbselect($library_upit);
        $library_objekt = $library_rezultat->fetch_object();
        if(((time() + pomak()) - $_SESSION["trajanje"]) > intval($library_objekt->sesija)){
            session_unset();
            session_destroy();
            header("Location: prijava.php");
        }   
        else{
            $_SESSION["trajanje"] = strtotime(date("Y-m-d H:i:s", time() + pomak()));
        }
        $library_database->dbclose();
    }
}

function pomak() {
    $pomak_database = new Baza();
    $pomak_database->dbconnect();
    $rezultat = $pomak_database->dbselect("SELECT pomak FROM config");
    $pomak = $rezultat->fetch_object();
    $pomak_database->dbclose();
    unset($pomak_database);
    return (60 * 60 * $pomak->pomak);
}

function postavke() {
    global $library_database;
    $library_database->dbconnect();
    $library_upit = "SELECT * FROM config";
    $library_rezultat = $library_database->dbselect($library_upit);
    $library_objekt = $library_rezultat->fetch_object();
    return $library_objekt;
}

?>