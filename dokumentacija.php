<?php

    require("biblioteka.php");
    provjeri_uvjete();
    session_timeout();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dokumentacija</title>
        <meta charset="UTF-8">
        <meta name="keywords" content="Projekt, FOI, WebDiP, Teretana">
        <meta name="date" content="05-05-2017">
        <meta name="author" content="Vedran Gložinić">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/style.css" rel="stylesheet" media="screen" type="text/css">
        <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
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
                    DOKUMENTACIJA
                </div>
                
                <div id="menu"> 
                     <ul>
                        <?php navigacija(); ?>
                     </ul>    
                     <hr>
                </div>

                <div id="content">
                    <h2>Opis projektnog zadatka</h2>
                    <p class="ravnomjerno margin_top">
                        Projektni zadatak bio je izraditi sustav koji omogućuje prijave na trening i praćenje evidencije u teretani.
                        Glavne uloge ovog sustava su administrator, moderator, registrirani i neregistrirani korisnik, od kojih
                        administrator ima najviše opcija, a neregistrirani korisnik najmanje.
                        Administrator ima pregled nad sustavom, može stvarati vrste programa i kupone te mijenjati podatke 
                        iz različitih tablica kojima ostali nemaju pristup. Također može pregledavati statistiku lojalnosti
                        članova teretane i dnevnik sustava.
                        Moderator je određen kao trener nekog programa. On može stvarati i ukidati programe nad kojima je nadležan
                        te zabraniti pristup korisnicima ukoliko ne izvršavaju svoje obaveze. Uz to, može evidentirati dolaske polaznicima
                        programa te definirati termine u kojima se program izvodi i definirati kupone za svoj program.
                        Registrirani korisnik može se prijaviti u programe koji nisu puni te pregledavati opise napredovanja
                        za svoje dolaske na tom programu. Uz to skuplja bodove koje može potrošiti na kupone popusta
                        za određeni program. Neregistrirani korisnik može vrste programa sa najviše dolazaka po programu.
                    </p>
                    <h2>Opis projektnog rješenja</h2>
                    <p class="ravnomjerno margin_top">
                        Projektni zadataku pristupio sam metodom od gore prema dolje. Prva napravljena stvar bila je dizajn. 
                        Nakon toga napravljena je registracija, aktivacija i prijava, a poslije toga napravljen je ispis korisnika.
                        Poslije toga napravljena je biblioteka u kojoj su funkcije za rad sustava. Metodom su prvo napravljene
                        ovlasti i akcije administratora s kojima je bilo lakše upravljati daljnjim radom sustava.
                        Pod administrator napravljena je većina opcija, pa se nakon toga moglo krenuti s ostalim ulogama.
                        Neregistrirani korisnik napravljen je kao kostur za provjeravanje uloga, te se nakon toga krenulo na
                        moderatora i registriranog korisnika koji su se radili istovremeno. Razlog tome je da registrirani korisnik i
                        moderator više ovise jedan o drugome od moderatora. Glavne stavke projektnog zadatka su se stoga mogle
                        raditi uz pomoć izrađenog programskog okvira te ih je bilo puno lakše za napraviti, no više o tome u završenosti projekta.
                    </p>
                    <h2>Bitne odrednice projektnog rješenja</h2>
                    <p class="ravnomjerno margin_top">
                        ERA model projektnog rješenja može se vidjeti <a href="slike/era.png" target="_blanl">ovdje</a>, no navigacijski dijagram
                        i mapa mjesta nisu izrađeni.
                    </p>
                    <h2>Popis i opis skripata</h2>
                    <p class="ravnomjerno margin_top">
                        Skripte u ovom projektu su PHP i JavaScript skripte. PHP skripte su opisane ispod i podijeljene su u sedam kategorija:
                        <ul class="ravnomjerno">
                            <li><i>a_nesto</i> - strukturna skripta kojoj može pristupiti samo administrator</li>
                            <li><i>admin_nesto</i> - logika za manipulaciju podacima iz baze podataka za administratora</li>
                            <li><i>m_nesto</i> - strukturna skripta kojoj mogu pristupiti administrator i moderator</li>
                            <li><i>mod_nesto</i> - logika za manipulaciju podacima iz baze podataka za moderatore</li>
                            <li><i>u_nesto</i> - strukturna skripta kojoj može pristupiti svi prijavljeni korisnici aplikacije</li>
                            <li><i>user_nesto</i> - logika za manipulaciju podacima iz baze podataka za registriranog korisnika</li>
                            <li><i>nesto</i> - ostale skripte koje služe za provjere ili im mogu pristupiti svi korisnici</li>
                        </ul>
                    </p>
                    <p class="ravnomjerno margin_top">
                        <span class="podebljano">Popis PHP skripata:</span>
                        <br><span class="podebljano">></span>&nbsp; <i>a_dnevnik</i> - skripta za pregled dnevnika
                        <br><span class="podebljano">></span>&nbsp; <i>a_dodaj_kupon</i> - skripta za dodavanje novog kupona popusta
                        <br><span class="podebljano">></span>&nbsp; <i>a_dodaj_moderatora</i> - skripta za pretvorbu običnog korisnika u moderatora
                        <br><span class="podebljano">></span>&nbsp; <i>a_dodaj_vrstu</i> - skripta za dodavanje nove vrste programa
                        <br><span class="podebljano">></span>&nbsp; <i>a_dodijeli_moderatora</i> - skripta za dodjelu moderatora vrsti programa
                        <br><span class="podebljano">></span>&nbsp; <i>a_korisnici</i> - skripta za promjenu određenih podataka korisnicima
                        <br><span class="podebljano">></span>&nbsp; <i>a_kuponi</i> - skripta za pregled trentnih kupona u aplikaciji
                        <br><span class="podebljano">></span>&nbsp; <i>a_makni_ovlasti</i> - skripta za micanje ovlasti moderatora sa korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>a_moderatori</i> - skripta za pregled moderatora po vrstama
                        <br><span class="podebljano">></span>&nbsp; <i>a_otkljucavanje_korisnika</i> - skripta za otključavanje zaključanih korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>a_postavke_sustava</i> - skripta za mijenjanje postavki sustava
                        <br><span class="podebljano">></span>&nbsp; <i>a_statistika</i> - skripta za pregled i filtriranje statistike lojalnosti
                        <br><span class="podebljano">></span>&nbsp; <i>a_ukloni_kupon</i> - skripta za brisanje kupona iz aplikacije
                        <br><span class="podebljano">></span>&nbsp; <i>a_ukloni_moderatora</i> - skripta za micanje ovlasti moderatora korisniku
                        <br><span class="podebljano">></span>&nbsp; <i>a_ukloni_vrstu</i> - skripta za brisanje vrste programa vježbanja
                        <br><span class="podebljano">></span>&nbsp; <i>a_virtualno_vrijeme</i> - skripta za postavljanje virtualnog vremena
                        <br><span class="podebljano">></span>&nbsp; <i>a_vrste_programa</i> - skripta za pregled vrsta programa
                        <br><span class="podebljano">></span>&nbsp; <i>a_zakljucavanje_korisnika</i> - skripta za zaključavanje korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>a_zamijeni_moderatora</i> - zamjena moderatora za određeni program
                        <br><span class="podebljano">></span>&nbsp; <i>admin_brisanje_kupona</i> - skripta koja briše sve kupone iz baze i njihove datoteke
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dbk</i> - skripta koja dohvaća sve zaključane korisnike
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dodijeli_moderatora</i> - skripta koja upisuje moderatore u bazu podataka
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_dnevnika</i> - skripta koja dohvaća podatke iz dnevnika uz parametre sortiranja
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_frekvencije</i> - skripta koja dohvaća frekvenciju rada korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_jednog</i> - skripta koja dohvaća podatke o jednom korisniku
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_korisnika</i> - skripta koja dohvaća sve korisnike u aplikaciji
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_kupona</i> - skripta koje dohvaća sve kupone u aplikaciji
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_kzb</i> - skripta koja dohvaća registrirane korisnike i stanje bodova
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_moderatora</i> - skripta koja dohvaća sve moderatore
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_mzp</i> - skripta koja dohvaća moderatore za programe
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_mzv</i> - skripta koja dohvaća moderatore za vrste programa
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_postavki</i> - skripta koje dohvaća postavke sustava
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_programa</i> - skripta koja dohvaća sve programe i njihove trenere
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_statistike</i> - skripta koja dohvaća statističke podatke po određenim parametrima
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_svih</i> - skripta koja dohvaća sve moderatore i registrirane korisnike
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dohvacanje_vrsta</i> - skripta koja dohvaća jednu ili sve vrste programa
                        <br><span class="podebljano">></span>&nbsp; <i>admin_dok</i> - skripta koja dohvaća sve otključane korisnike
                        <br><span class="podebljano">></span>&nbsp; <i>admin_micanje_ovlasti</i> - skripta koja miče ulogu moderatora s određenog korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>admin_postavi_vrijeme</i> - skripta koja postavlja virtualno vrijeme u bazi podataka
                        <br><span class="podebljano">></span>&nbsp; <i>admin_provjera_email</i> - skripta koja provjerava e-mail za sve korisnike osim odabranog
                        <br><span class="podebljano">></span>&nbsp; <i>admin_ukloni_moderatora</i> - skripta koja miče moderatora iz vrste programa
                        <br><span class="podebljano">></span>&nbsp; <i>admin_ukloni_vrstu</i> - skripta koje briše vrstu programa
                        <br><span class="podebljano">></span>&nbsp; <i>admin_zamijeni_moderatora</i> - skripta koje zamijenjuje moderatora u bazi podataka
                        <br><span class="podebljano">></span>&nbsp; <i>admin_zapisi_moderatora</i> - skripta koja zapisuje korisnika kao moderatora u bazi podataka
                        <br><span class="podebljano">></span>&nbsp; <i>admin_zapisivanje_korisnika</i> - skripta koja mijenja podatke o korisniku u bazu podataka
                        <br><span class="podebljano">></span>&nbsp; <i>admin_zapisivanje_postavki</i> - skripta koja zapisuje postavke sustava u bazu podataka
                        <br><span class="podebljano">></span>&nbsp; <i>admin_zapisivanje_vrste</i> - skripta koja dodaje novu vrstu programa
                        <br><span class="podebljano">></span>&nbsp; <i>admin_zbk</i> - skripta koja zaključava jednog ili sve korisnike
                        <br><span class="podebljano">></span>&nbsp; <i>admin_zok</i> - skripta koja otključava jednog ili sve korisnike
                        <br><span class="podebljano">></span>&nbsp; <i>aktivacija</i> - skripta koja aktivira registriranog korisnika i dodijeljuje početne bodove
                        <br><span class="podebljano">></span>&nbsp; <i>baza_class</i> - skripta sa klasom i metodama za rad s bazom podataka
                        <br><span class="podebljano">></span>&nbsp; <i>biblioteka</i> - skripta sa pomoćnim funkcijama za sesije, bodove, statistiku, postavke, uloge itd.
                        <br><span class="podebljano">></span>&nbsp; <i>dohvacanje_korisnika</i> - skripta koja dohvaća sve korisnike u aplikaciji
                        <br><span class="podebljano">></span>&nbsp; <i>dohvacanje_programa</i> - skripta koja dohvaća dolaske na sve programe u aplikaciji
                        <br><span class="podebljano">></span>&nbsp; <i>dohvacanje_vrsta</i> - skripta koja dohvaća sve vrste u aplikaciji
                        <br><span class="podebljano">></span>&nbsp; <i>dokumentacija</i> - skripta koja dokumentira rad i opisuje proces rađenja aplikacije
                        <br><span class="podebljano">></span>&nbsp; <i>index</i> - skripta početne stranice aplikacije
                        <br><span class="podebljano">></span>&nbsp; <i>m_dodaj_kupon</i> - skripta u kojoj moderator definira kupon za programe koje vodi
                        <br><span class="podebljano">></span>&nbsp; <i>m_dodaj_program</i> - skripta u kojoj moderator definira novi program vježbanja
                        <br><span class="podebljano">></span>&nbsp; <i>m_dodaj_termin</i> - skripta u kojoj moderator može dodati novi termin za program vježbanja
                        <br><span class="podebljano">></span>&nbsp; <i>m_kuponi</i> - skripta koja služi za pregled svih kupona za moderatorove programe
                        <br><span class="podebljano">></span>&nbsp; <i>m_polaznici</i> - skripta koja služi za pregled, ispis i zabranu polaznika određenog programa
                        <br><span class="podebljano">></span>&nbsp; <i>m_programi</i> - skripta koja služi za pregled i ukidanje programa za određenog moderatora
                        <br><span class="podebljano">></span>&nbsp; <i>m_provjeri_kupon</i> - skripta koja služi za provjeru koda kupona
                        <br><span class="podebljano">></span>&nbsp; <i>m_termini</i> - skripta koja služi za pregled svih termina programa kojih moderator vodi
                        <br><span class="podebljano">></span>&nbsp; <i>m_ukloni_kupon</i> - skripta koja briše kupon za određeni program koji moderator vodi
                        <br><span class="podebljano">></span>&nbsp; <i>m_zamijeni_termin</i> - skripta koja definira i mijenja određeni termin programa
                        <br><span class="podebljano">></span>&nbsp; <i>mod_deaktiviranje_kupona</i> - skripta koja deaktivira jednog ili više kupona za program
                        <br><span class="podebljano">></span>&nbsp; <i>mod_definiranje_kupona</i> - skripta koja zapisuje kupon za određeni program u bazu podataka
                        <br><span class="podebljano">></span>&nbsp; <i>mod_dohvacanje_kupona</i> - skripta koja dohvaća postojeće ili nepostojeće kupone za program
                        <br><span class="podebljano">></span>&nbsp; <i>mod_dohvacanje_polaznika</i> - skripa koja dohvaća sve zaključane ili otključane polaznike za program
                        <br><span class="podebljano">></span>&nbsp; <i>mod_dohvacanje_programa</i> - skripta koja dohvaća sve aktivne programe koje vodi moderator
                        <br><span class="podebljano">></span>&nbsp; <i>mod_dohvacanje_pzm</i> - skripta koja dohvaća detalje o programu koji je odabran
                        <br><span class="podebljano">></span>&nbsp; <i>mod_dohvacanje_pzp</i> - skripta koja dohvaća sve zabranjene polaznike za odabrani program
                        <br><span class="podebljano">></span>&nbsp; <i>mod_dohvacanje_termina</i> - skripta koja dohvaća sve definirane aktivne termine za program
                        <br><span class="podebljano">></span>&nbsp; <i>mod_dohvacanje_vrsta</i> - skripta koja dohvaća vrste programa za koje je moderator zadužen
                        <br><span class="podebljano">></span>&nbsp; <i>mod_ispisi_korisnika</i> - skripta koja trajno ispisuje korisnika iz programa vježbanja
                        <br><span class="podebljano">></span>&nbsp; <i>mod_ukidanje_programa</i> - skripta koja trajno ukida izvođenje programa vježbanja
                        <br><span class="podebljano">></span>&nbsp; <i>mod_zabrani_dozvoli</i> - skripta koja zabranjuje ili dopušta pristup programu za polaznika
                        <br><span class="podebljano">></span>&nbsp; <i>mod_zapisi_program</i> - skripta koja zapisuje novi program vježbanja u bazu podataka
                        <br><span class="podebljano">></span>&nbsp; <i>mod_zapisi_termin</i> - skripta koja zapisuje novi termin za program vježbanja u bazu podataka
                        <br><span class="podebljano">></span>&nbsp; <i>najbolji_programi</i> - skripta koja prikazuje najpohađanije programe po vrsti
                        <br><span class="podebljano">></span>&nbsp; <i>o_autoru</i> - skripta sa osnovnim informacijama o autoru ove web aplikacije
                        <br><span class="podebljano">></span>&nbsp; <i>odjava</i> - skripta koja briše sesiju i odjavljuje korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>ponovo_poslano</i> - skripta koja ponovo šalje aktivacijski kod na e-mail korisnika 
                        <br><span class="podebljano">></span>&nbsp; <i>posalji_lozinku</i> - skripta koja šalje novu generirano lozinku na e-mail korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>prijava</i> - skripta koja prijavljuje korisnika pomoću korisničkog imena, lozinke i koda prijave
                        <br><span class="podebljano">></span>&nbsp; <i>provjera_email</i> - skripta provjerava postoji li takav e-mail već u bazi podataka
                        <br><span class="podebljano">></span>&nbsp; <i>provjera_kod</i> - skripta provjerava postoji li takav kod kupona u bazi podataka
                        <br><span class="podebljano">></span>&nbsp; <i>provjera_kupon</i> - skripta provjerava postoji li već takav kupon u bazi podataka
                        <br><span class="podebljano">></span>&nbsp; <i>provjera_login</i> - skripta provjerava je li korisnik zabranjen ili nema aktiviran račun
                        <br><span class="podebljano">></span>&nbsp; <i>provjera_termin</i> - skripta provjerava je li takav termin zauzet za određeni program
                        <br><span class="podebljano">></span>&nbsp; <i>provjera_username</i> - skripta provjerava postoji li takvo korisničko ime već u bazi
                        <br><span class="podebljano">></span>&nbsp; <i>registracija</i> - skripta na kojoj se neregistrirani korisnici mogu registrirati
                        <br><span class="podebljano">></span>&nbsp; <i>registrirano</i> - skripta koja daje povratnu informaciju o uspješnosti registracije
                        <br><span class="podebljano">></span>&nbsp; <i>tos</i> - skripta na kojoj su objašnjeni uvjeti korištenja i prihvaćanje istih
                        <br><span class="podebljano">></span>&nbsp; <i>u_bodovi</i> - skripta koja prikazuje stanje bodova i radnje koje su dodijelile bodove
                        <br><span class="podebljano">></span>&nbsp; <i>u_kosarica</i> - skripta na kojoj se kuponi u košarici mogu kupiti ili maknuti
                        <br><span class="podebljano">></span>&nbsp; <i>u_lozinka_promijenjena</i> - skripta koja potvrđuje da je lozinka uspješno promijenjena
                        <br><span class="podebljano">></span>&nbsp; <i>u_moji_programi</i> - skripta na kojoj korisnik vidi u koje je programe vježbanja upisan
                        <br><span class="podebljano">></span>&nbsp; <i>u_povijest_kupnje</i> - skripta na kojoj korisnik vidi kupoljene kupone i može ih isprintati
                        <br><span class="podebljano">></span>&nbsp; <i>u_pregled_kupona</i> - skripta na kojoj se kuponi mogu pregledavati i dodavati u košaricu
                        <br><span class="podebljano">></span>&nbsp; <i>u_pregled_programa</i> - skripta na kojoj korisnik može pregledavati i upisati se u program
                        <br><span class="podebljano">></span>&nbsp; <i>u_profil</i> - skripta na kojoj se mogu mijenjati osnovne postavke profila korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>u_promjena_lozinke</i> - skripta na kojoj korisnik može promijeniti lozinku
                        <br><span class="podebljano">></span>&nbsp; <i>u_radnje</i> - skripta sa popisom i opisom radnji za skupljanje bodova
                        <br><span class="podebljano">></span>&nbsp; <i>user_dohvacanje_bodova</i> - skripta za dohvaćanje skupljenih bodova iz statistike
                        <br><span class="podebljano">></span>&nbsp; <i>user_dohvacanje_kosarice</i> - skripta za dohvaćanje kupona koji se nalaze u košarici
                        <br><span class="podebljano">></span>&nbsp; <i>user_dohvacanje_kupona</i> - skripta koja dohvaća informacije o kuponu popusta
                        <br><span class="podebljano">></span>&nbsp; <i>user_dohvacanje_opis</i> - skripta koja dohvaća informacije o aktivnom programu vježbanja
                        <br><span class="podebljano">></span>&nbsp; <i>user_dohvacanje_povijesti</i> - skripta koja dohvaća sve kupljene kupone za određenog korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>user_dohvacanje_profila</i> - skripta koja dovhaća podatke za određenog korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>user_dohvacanje_programa</i> - skripta koja dohvaća upisane i neupisane programe za korisnika
                        <br><span class="podebljano">></span>&nbsp; <i>user_ispis_kupona</i> - skripta koja dohvaća informacije o kuponu za ispis iz povijesti kupnje
                        <br><span class="podebljano">></span>&nbsp; <i>user_kosarica</i> - skripta koja dodaje ili miče kupon popusta iz košarice
                        <br><span class="podebljano">></span>&nbsp; <i>user_kupnja_kupona</i> - skripta koja kupuje sve kupone popusta koji su u košarici
                        <br><span class="podebljano">></span>&nbsp; <i>user_prijava</i> - skripta u kojoj se korisnik prijavljuje u program vježbanja
                        <br><span class="podebljano">></span>&nbsp; <i>user_zapisi_profil</i> - skripta u kojoj se ažuriraju korisnički podaci u bazi podataka
                        <br><span class="podebljano">></span>&nbsp; <i>zaboravljena lozinka</i> - skripta na kojoj se unosi korisničko ime na koje se šalje nova lozinka
                    </p>
                    <h2>Korištene tehnologije i alati</h2>
                    <p class="ravnomjerno">
                        <ul class="ravnomjerno">
                            <li><span class="podebljano">HTML</span> - tekstualni jezik oznaka koji se koristi za izradu strukture web stranice</li>
                            <li><span class="podebljano">CSS</span> - kaskadni stilski jezik koji služi za dizajn i prezentaciju strukture web stranice ili mjesta</li>
                            <li><span class="podebljano">JavaScript</span> - skriptni programski jezik koji služi za dinamičko generiranje sadržaja na klijentskoj strani</li>
                            <li><span class="podebljano">PHP</span> - skriptni programski jezik koji se izvršava na poslužitelju te služi za dinamički dohvat podataka</li>
                            <li><span class="podebljano">VS Code</span> - besplatno programsko okruženje proizvedeno od Microsofta kao uređivač koda sličan MS Visual Studiu</li>
                            <li><span class="podebljano">phpMyAdmin</span> - programski alat koji služi za upravljanje MySQL bazom podataka i podacima unutar nje</li>
                        </ul>
                    </p>
                    <h2>Vanjske skripte i biblioteke</h2>
                    <p class="ravnomjerno">
                        <ul class="ravnomjerno">
                            <li><span class="podebljano">Baza</span> (Matija Novak, FOI) - PHP biblioteka za funkcije za spajanje i upravljanje s bazom podataka</li>
                            <li><span class="podebljano">jQuery</span> (John Resig, MIT) - JavaScript biblioteka koja olakšava skriptiranje na klijentskoj strani</li>
                            <li><span class="podebljano">jsPDF</span> (James Hall, MIT) - JavaScript biblioteka koja omogućava generiranje PDF dokumenata</li>
                        </ul>
                    </p>
                    <h2>Završenost projekta</h2>
                    <p class="ravnomjerno">
                        Projekt nije u potpunosti završen. Procijenjuje se da je završeno malo više od pola projekta, od čega većina radi bez pogrešaka. 
                        Testovi su rađeni uz programiranje, a stvari koje nisu napravljene navedene su ispod.
                    </p>
                    <p class="ravnomjerno">
                        <span class="podebljano">Administrator:</span> Kod administratora se kod statistike lojalnosti ne mogu pretraživati zapisi po rasponu vremena.
                        <br>
                        <span class="podebljano">Moderator:</span> Kod administratora nema izgleda stranice i ne može voditi evidenciju polaznicima programa.
                        <br>
                        <span class="podebljano">Korisnik:</span> Ne može vidjeti pregledavati evidenciju dolazaka i ne može dijeliti sadržaje na društvenu mrežu.
                        <br>
                        <span class="podebljano">Ostalo</span> - Ne postoji sortiranje  i pretraživanje po stupcima za tablice
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - U dnevniku nema upita s bazom podataka
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - Za administratora ne postoji CRUD opcije za sve tablice
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - Kod posebnih osobina postoji samo zaštita od SQL ubacivanja
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - Konfiguracija sustava nema opciju za izgled stranice
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        - Ne postoji graf, ispis i generiranje PDF dokumenta za statistiku
                    </p>
                    <h2>Otkrivene pogreške u radu</h2>
                    <p class="ravnomjerno margin_top">
                        - Na određenim stranicama (npr. prijava i korisnici) potrebno je dvaput kliknuti gumb kako bi se promjene ažurirale ako je u prošlom kliku došlo do pogreške unosa
                        <br>
                        - Administrator ne može postati trener niti jednom programu, te nije uključen kao trener kada se stvara nova vrsta programa
                    </p>
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