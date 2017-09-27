$(document).ready(function(){

    flag_ime = false;
    flag_prezime = false;
    flag_broj = false;

    $.ajax({
        url: "user_dohvacanje_profila.php",
        method: "GET",
        dataType: "json",
        success: function (podaci) {
            html = "";
            html += "<span class=\"podebljano\">Korisničko ime:</span> " + podaci[0].username + "<br>";
            html += "<span class=\"podebljano\">E-mail:</span> " + podaci[0].email;
            $("#profil").html(html);
            $("#ime").val(podaci[0].ime);
            $("#prezime").val(podaci[0].prezime);
            $("#broj").val(podaci[0].mobitel);
            $("#dual").val(podaci[0].dual);
        }
    });

    $("#ime").focusout(function() {
        if($("#ime").val() === ""){
            flag_ime = false;
            $("#ime").addClass("krivo");
            $("#error_ime").html("Ime nije uneseno!");
        }
        else{
            if($("#ime").val().length >= 2 && $("#ime").val().length <= 50){

                regex = /^[A-ZŠĐČĆŽ][A-ZŠĐČĆŽa-zđčćšž\- ]*[a-zđčćšž]$/;

                if(regex.test($("#ime").val())){
                    flag_ime = true;
                    $("#ime").removeClass("krivo");
                    $("#error_ime").html("");
                }
                else{
                    $("#ime").addClass("krivo");
                    flag_ime = false;

                    regex_first = /[A-ZŠĐČĆŽ]/;
                    regex_last = /[a-zđčćšž]/;

                    error = "";
                    flag_error = false;
                    
                    if(!regex_first.test($("#ime").val()[0])){
                        error += "Ime mora početi s velikim slovom!";
                        flag_error = true;
                    }
                    if(!regex_last.test($("#ime").val()[$("#ime").val().length-1])){
                        if(flag_error == true){
                            error += "<br>";
                        }
                        else{
                            flag_error = true;
                        }
                        error += "Zadnji znak imena mora biti malo slovo!";
                    }
                    if(!flag_error){
                        $("#error_ime").html("Ime može sadržavati slova, razmak i crticu!");
                    }
                    else{
                        $("#error_ime").html(error);
                    }
                }
            }
            else{
                flag_ime = false;
                $("#ime").addClass("krivo");
                $("#error_ime").html("Ime mora biti između 2 i 50 znakova!");
            }
        }
    });

    $("#prezime").focusout(function() {
        if($("#prezime").val() === ""){
            flag_prezime = false;
            $("#prezime").addClass("krivo");
            $("#error_prezime").html("Prezime nije uneseno!");
        }
        else{
            if($("#prezime").val().length >= 2 && $("#prezime").val().length <= 50){

                regex = /^[A-ZŠĐČĆŽ][A-ZŠĐČĆŽa-zđčćšž\- ]*[a-zđčćšž]$/;

                if(regex.test($("#prezime").val())){
                    flag_prezime = true;
                    $("#prezime").removeClass("krivo");
                    $("#error_prezime").html("");
                }
                else{
                    $("#prezime").addClass("krivo");
                    flag_prezime = false;

                    regex_last = /[a-zđčćšž]/;
                    regex_first = /[A-ZŠĐČĆŽ]/;

                    error = "";
                    flag_error = false;
                    
                    if(!regex_first.test($("#prezime").val()[0])){
                        error += "Prezime mora početi s velikim slovom!";
                        flag_error = true;
                    }
                    if(!regex_last.test($("#prezime").val()[$("#prezime").val().length-1])){
                        if(flag_error == true){
                            error += "<br>";
                        }
                        else{
                            flag_error = true;
                        }
                        error += "Zadnji znak prezimena mora biti malo slovo!";
                    }
                    if(!flag_error){
                        $("#error_prezime").html("Prezime može sadržavati slova, razmak i crticu!");
                    }
                    else{
                        $("#error_prezime").html(error);
                    }
                }
            }
            else{
                flag_prezime = false;
                $("#prezime").addClass("krivo");
                $("#error_prezime").html("Prezime mora biti između 2 i 50 znakova!");
            }
        }
    });

    $("#broj").focusout(function() {
        if($("#broj").val() === ""){
            flag_broj = false;
            $("#broj").addClass("krivo");
            $("#error_broj").html("Broj mobitela nije unesen!");
        }
        else{
            if($("#broj").val().length >= 8 && $("#broj").val().length <= 20){
                
                regex_long = /^[+][0-9]{1,3} [0-9]{2} [0-9]{3} [0-9]{3,4}$/;
                regex_short = /^[0-9]{3} [0-9]{3} [0-9]{3,4}$/;

                if(regex_long.test($("#broj").val()) || regex_short.test($("#broj").val())){
                    flag_broj = true;
                    $("#broj").removeClass("krivo");
                    $("#error_broj").html("");
                }
                else{
                    flag_broj = false;
                    $("#broj").addClass("krivo");
                    $("#error_broj").html("Broj nije u ispravnom obliku! <br> (npr. +385 91 234 5678 ili 091 234 5678)");
                }
            }
            else{
                flag_broj = false;
                $("#broj").addClass("krivo");
                $("#error_broj").html("Broj mobitela mora biti između 8 i 20 znakova!");
            }
        }
    });

    $("#spremi").click(function () {

        $("#ime").blur();
        $("#prezime").blur();
        $("#broj").blur();

        if(flag_broj && flag_ime && flag_prezime){
            $.ajax({
                type: "GET",
                url: "user_zapisi_profil.php",
                dataType: "json",
                data: {"ime":$("#ime").val(), "prezime":$("#prezime").val(), "broj":$("#broj").val(), "dual":$("#dual").val()},
                success: function (podaci) {
                    if(podaci === "success"){
                        $("#error_status").html("Uspješno ste ažurirali profil!");   
                    }
                    else{
                        $("#error_status").html("Dogodila se pogreška kod ažuriranja profila.");
                    }
                }
            });
        } 
    });  
    
});