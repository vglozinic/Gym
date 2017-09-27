$(document).ready(function(){

    var flag_OK = false;
    var flag_ime = false;
    var flag_prezime = false;
    var flag_username = false;
    var flag_email = false;
    var flag_lozinka = false;
    var flag_potvrda = false;
    var flag_datum = false;
    var flag_broj = false;
    var flag_captcha = false;

    function checkLength(value, lowest, highest){
        if((value.length >= lowest) && (value.length <= highest)){
            return true;
        }
        else{
            return false;
        }
    }

    function addError(name, message){
        $("#" + name).addClass("krivo");
        $("#error_" + name).html(message);
        return false;
    }

    function removeError(name){
        $("#" + name).removeClass("krivo");
        $("#error_" + name).html("");
        return true;
    }

    function checkDate(dan, mjesec, godina){

        leap_year = false;
        kalendar = [31,28,31,30,31,30,31,31,30,31,30,31];
        if (dan > 31 || mjesec > 12 || dan == 0 || mjesec == 0 || godina == 0){
            return false;
        }

        if(godina % 4 == 0){
            if(godina % 100 == 0){
                if(godina % 400 == 0){
                    leap_year = true;
                }
            }
            else{
                leap_year = true;
            }
        }
        
        if(dan <= kalendar[mjesec-1]){
            return true;
        }
        else{
            if(mjesec == 2 && leap_year && dan == 29){
                return true;
            }
            else{
                return false;
            }
        }
    }

    function checkFull(dan, mjesec, godina){

        trenutna = new Date();
        
        if(godina < (trenutna.getFullYear()-18)){
            return true;
        }
        else{
            if(godina == (trenutna.getFullYear()-18)){
                if(mjesec < trenutna.getMonth()+1){
                    return true;
                }
                else{
                    if(mjesec == trenutna.getMonth()+1){
                        if(dan <= trenutna.getDate()){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                    else{
                        return false;
                    }
                }
            }
            else{
                return false;
            }
        }
    }

    $("#ime").focusout(function() {
        if($("#ime").val() === ""){
            flag_ime = addError("ime", "Ime nije uneseno!");     
        }
        else{
            if(checkLength($("#ime").val(),2,50)){

                regex = /^[A-ZŠĐČĆŽ][A-ZŠĐČĆŽa-zđčćšž\- ]*[a-zđčćšž]$/;

                if(regex.test($("#ime").val())){
                    flag_ime = removeError("ime");
                }
                else{
                    regex = /[a-zđčćšž]/;
                    if(regex.test($("#ime").val()[$("#ime").val().length-1])){
                        flag_ime = addError("ime", "Ime mora početi s velikim slovom i može sadržavati slova, razmak i crticu!");
                    }
                    else{
                        flag_ime = addError("ime", "Zadnji znak imena mora biti malo slovo!");
                    }
                }
            }
            else{
                flag_ime = addError("ime", "Ime mora biti između 2 i 50 znakova!");
            }
        }
    });

    $("#prezime").focusout(function() {
        if($("#prezime").val() === ""){
            flag_prezime = addError("prezime", "Prezime nije uneseno!");
        }
        else{
            if(checkLength($("#prezime").val(),2,50)){

                regex = /^[A-ZŠĐČĆŽ][A-ZŠĐČĆŽa-zđčćšž\- ]*[a-zđčćšž]$/;

                if(regex.test($("#prezime").val())){
                    flag_prezime = removeError("prezime");
                }
                else{
                    regex = /[a-zđčćšž]/;
                    if(regex.test($("#prezime").val()[$("#prezime").val().length-1])){
                        flag_prezime = addError("prezime", "Prezime mora početi s velikim slovom i može sadržavati slova, razmak i crticu!");
                    }
                    else{
                        flag_prezime = addError("prezime", "Zadnji znak prezimena mora biti malo slovo!");
                    }
                }
            }
            else{
                flag_prezime = addError("prezime", "Prezime mora biti između 2 i 50 znakova!");
            }
        }

    });

    $("#username").focusout(function() {

        if($("#username").val() === ""){
            flag_username = addError("username", "Korisničko ime nije uneseno!");
        }
        else{
            if(checkLength($("#username").val(),8,25)){

                regex = /^[a-z0-9][a-z0-9.\-_]*[a-z0-9]$/;

                if(regex.test($("#username").val())){

                    $.ajax({
                    url: "provjera_username.php",
                    method: "GET",
                    data: {"username": $("#username").val()},
                    dataType: "json",
                    success: function(podaci) {
                        if(podaci === "taken") {
                            flag_username = addError("username", "Korisničko ime je zauzeto!");
                        }
                        else{
                            flag_username = removeError("username");
                            }
                        }
                    });

                }
                else{   
                    regex = /[a-z0-9]/;
                    if(regex.test($("#username").val()[$("#username").val().length-1]) && regex.test($("#username").val()[0])){
                        flag_username = addError("username", "Korisničko ime može sadržavati mala slova, brojke, crticu, točku i podvlaku!");
                    }
                    else{
                        flag_username = addError("username", "Korisničko ime mora počinjati i završavati malim slovom ili brojkom!");
                    }
                }
            }
            else{
                flag_username = addError("username", "Korisničko ime mora biti između 8 i 25 znakova!");
            }
        }

    });

    $("#email").focusout(function() {

        if($("#email").val() === ""){
            flag_email = addError("email", "E-mail nije unesen!");
        }
        else{
            if(checkLength($("#email").val(),8,50)){

                regex = /^[A-Za-z0-9._\-\@]+$/;

                if(regex.test($("#email").val())){

                    regex = /^[A-Za-z0-9]+[A-Za-z0-9._\-]+@[A-Za-z0-9]+[A-Za-z0-9._\-]+\.[a-z]{2,3}$/;

                    if(regex.test($("#email").val())){
                        $.ajax({
                        url: "provjera_email.php",
                        method: "GET",
                        data: {"email": $("#email").val()},
                        dataType: "json",
                        success: function(podaci) {
                            if(podaci === "taken") {
                                flag_email = addError("email", "E-mail je zauzet!");
                            }
                            else{
                                flag_email = removeError("email");
                                }
                            }
                        });
                    }
                    else{
                        flag_email = addError("email", "E-mail nije u dobrom obliku! (npr. username@host.domain)");
                    }
                }
                else{
                    flag_email = addError("email", "E-mail može sadržavati mala i velika slova, brojke, točku, podvlaku i crticu!");
                }
            }
            else{
                flag_email = addError("email", "E-mail mora biti između 8 i 50 znakova!");
            }
        }

    });

    $("#lozinka").focusout(function() {
        if($("#lozinka").val() === ""){
            flag_lozinka = addError("lozinka", "Lozinka nije unesena!");
        }
        else{
            if(checkLength($("#lozinka").val(),8,50)){

                regex = /^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/;

                if(regex.test($("#lozinka").val())){
                    flag_lozinka = removeError("lozinka");
                }
                else{
                    regex = /[A-Za-z0-9]/;
                    if(regex.test($("#lozinka").val()[$("#lozinka").val().length-1]) && regex.test($("#lozinka").val()[0])){
                        flag_lozinka = addError("lozinka", "Lozinka može sadržavati mala i velika slova, brojke, podvlaku i crticu!");
                    }
                    else{
                        flag_lozinka = addError("lozinka", "Lozinka mora počinjati i završavati slovom ili brojkom!");
                    }
                }
                
            }
            else{
                flag_lozinka = addError("lozinka", "Lozinka mora biti između 8 i 50 znakova!");
            }
        }

    });

    $("#potvrda").focusout(function() {
        if($("#potvrda").val() === ""){
            flag_potvrda = addError("potvrda", "Potvrda lozinke nije unesena!");
        }
        else{
            if($("#potvrda").val() === $("#lozinka").val()){
                flag_potvrda = removeError("potvrda");
            }
            else{
                flag_potvrda = addError("potvrda", "Potvrda lozinke se razlikuje od lozinke!");
            }
        }

    });

    $("#datum").focusout(function() {
        if($("#datum").val() === ""){
            flag_datum = addError("datum", "Datum rođenja nije unesen!");
        }
        else{

            regex = /^[0123][0-9]\.[01][0-9]\.[0-9]{4}\.$/;

            if(regex.test($("#datum").val())){
                if(checkDate(parseInt($("#datum").val().substring(0,2)),parseInt($("#datum").val().substring(3,5)),parseInt($("#datum").val().substring(6,10)))){
                    
                    if(checkFull(parseInt($("#datum").val().substring(0,2)),parseInt($("#datum").val().substring(3,5)),parseInt($("#datum").val().substring(6,10)))){
                        flag_datum = removeError("datum");
                    }
                    else{
                        flag_datum = addError("datum", "Niste punoljetni kako bi koristili aplikaciju!");
                    }
                }
                else{
                    flag_datum = addError("datum", "Datum nije ispravan!");
                }
                
            }
            else{
                flag_datum = addError("datum", "Datum nije u ispravnom formatu! (npr. 28.04.1994.)");
            }
        }

    });

    $("#broj").focusout(function() {
        if($("#broj").val() === ""){
            flag_broj = addError("broj", "Broj mobitela nije unesen!");
        }
        else{
            if(checkLength($("#broj").val(),8,20)){
                
                regex_long = /^[+][0-9]{1,3} [0-9]{2} [0-9]{3} [0-9]{3,4}$/;
                regex_short = /^[0-9]{3} [0-9]{3} [0-9]{3,4}$/;

                if(regex_long.test($("#broj").val()) || regex_short.test($("#broj").val())){
                    flag_broj = removeError("broj");
                }
                else{
                    flag_broj = addError("broj", "Broj nije u ispravnom obliku! (npr. +385 91 234 5678 ili 091 234 5678)");
                }
            }
            else{
                flag_broj = addError("broj", "Broj mobitela mora biti između 8 i 20 znakova!");
            }
        }

    });

    $("#footnote").hover(
        function(){
            $("#div_footnote").css("display","block");
            $("#div_footnote").css("visibility","visible");
        },
        function(){
            $("#div_footnote").css("display","none");
            $("#div_footnote").css("visibility","hidden");
    });


    $("#regform").submit(function(event){

        if($("#ime").val() === ""){
            flag_ime = addError("ime", "Ime nije uneseno!");
        }

        if($("#prezime").val() === ""){
            flag_prezime = addError("prezime", "Prezime nije uneseno!");
        }

        if($("#username").val() === ""){
            flag_username = addError("username", "Korisničko ime nije uneseno!");
        }

        if($("#email").val() === ""){
            flag_email = addError("email", "E-mail nije unesen!");
        }

        if($("#lozinka").val() === ""){
            flag_lozinka = addError("lozinka", "Lozinka nije unesena!");
        }

        if($("#potvrda").val() === ""){
            flag_potvrda = addError("potvrda", "Potvrda lozinke nije unesena!");
        }

        if($("#datum").val() === ""){
            flag_datum = addError("datum", "Datum rođenja nije unesen!");
        }

        if($("#broj").val() === ""){
            flag_broj = addError("broj", "Broj mobitela nije unesen!");
        }

        if(grecaptcha.getResponse() == "") {
            $("#error_captcha").html("Captcha nije označena!");
            flag_captcha = false;
        } 
        else {
            $("#error_captcha").html("");
            flag_captcha = true;
        }

        if(flag_ime && flag_prezime && flag_username && flag_email && flag_lozinka && flag_potvrda && flag_datum && flag_broj && flag_captcha) {
            flag_OK = true;
        }
        else{
            flag_OK = false;
        }

        if(!flag_OK){
            event.preventDefault();
        }
        
    });

});