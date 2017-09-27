$(document).ready(function(){

    flag_email = false;
    flag_broj = false;

    $.ajax({
        type: "GET",
        url: "admin_dohvacanje_svih.php",
        dataType: "json",
        success: function (podaci) {
            if(podaci !== "empty"){
                for (val of podaci) {
                    $("#korisnik").append("<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + " - " + val.uloga + "</option>");
                }
                $.ajax({
                    type: "GET",
                    url: "admin_dohvacanje_jednog.php",
                    dataType: "json",
                    data: {"id":$("#korisnik")[0].options[0].value},
                    success: function (podaci) {
                        $("#email").val(podaci.email);
                        $("#dual").val(podaci.dual_login);
                        $("#aktivan").val(podaci.aktivan);
                        $("#broj").val(podaci.broj_bodova);
                    }
                });
            }
        } 
    });

    $("#korisnik").change(function(){

        $("#error_status").html("");
        $("#error_email").html("");
        $("#error_broj").html("");

        $("#broj").removeClass("krivo");
        $("#email").removeClass("krivo");

        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_jednog.php",
            dataType: "json",
            data: {"id":$("#korisnik").val()},
            success: function (podaci) {
                $("#email").val(podaci.email);
                $("#dual").val(podaci.dual_login);
                $("#aktivan").val(podaci.aktivan);
                $("#broj").val(podaci.broj_bodova);
            }
        });
    });

    $("#email").focusout(function(){

        if($("#email").val() === ""){
            flag_email = false;
            $("#email").addClass("krivo");
            $("#error_email").html("E-mail nije unesen!");
            $("#error_status").html("");
        }
        else{
            if($("#email").val().length >= 8 && $("#email").val().length <= 50){

                regex = /^[A-Za-z0-9._\-\@]+$/;

                if(regex.test($("#email").val())){

                    regex = /^[A-Za-z0-9]+[A-Za-z0-9._\-]+@[A-Za-z0-9]+[A-Za-z0-9._\-]+\.[a-z]{2,3}$/;

                    if(regex.test($("#email").val())){
                        $.ajax({
                            async: false,
                            url: "admin_provjera_email.php",
                            method: "GET",
                            data: {"id":$("#korisnik").val(),"email":$("#email").val()},
                            dataType: "json",
                            success: function(podaci) {
                                if(podaci === "taken") {
                                    flag_email = false;
                                    $("#email").addClass("krivo");
                                    $("#error_email").html("E-mail je zauzet!");
                                    $("#error_status").html("");
                                }
                                else{
                                    flag_email = true;
                                    $("#email").removeClass("krivo");
                                    $("#error_email").html("");
                                }
                            }
                        });
                    }
                    else{
                        flag_email = false;
                        $("#email").addClass("krivo");
                        $("#error_email").html("E-mail nije u dobrom obliku! (npr. username@host.domain)");
                        $("#error_status").html("");
                    }
                }
                else{
                    flag_email = false;
                    $("#email").addClass("krivo");
                    $("#error_email").html("E-mail može sadržavati mala i velika slova, brojke, točku, podvlaku i crticu!");
                    $("#error_status").html("");
                }
            }
            else{
                flag_email = false;
                $("#email").addClass("krivo");
                $("#error_email").html("E-mail mora biti između 8 i 50 znakova!");
                $("#error_status").html("");
            }
        }

    });

    $("#broj").focusout(function(){

        if($("#broj").val() === ""){
            flag_broj = false;
            $("#broj").addClass("krivo");
            $("#error_broj").html("Broj bodova nije unesen!");
            $("#error_status").html("");
        }
        else{
            regex = /^[0-9]+$/;

            if(regex.test($("#broj").val())){
                if(parseInt($("#broj").val()) >= 0 && parseInt($("#broj").val()) <= 1000000){
                    flag_broj = true;
                    $("#broj").removeClass("krivo");
                    $("#error_broj").html("");
                }
                else{
                    flag_broj = false;
                    $("#broj").addClass("krivo");
                    $("#error_broj").html("Broj bodova može biti od nule do milijun!");
                    $("#error_status").html("");
                }
            }
            else{
                flag_broj = false;
                $("#broj").addClass("krivo");
                $("#error_broj").html("Broj bodova mora biti cijeli broj!");
                $("#error_status").html("");
            }
        }

    });

    $("#spremi").click(function(){

        $("#email").blur();
        $("#broj").blur();

        if(flag_broj && flag_email){

            $.ajax({
                async: false,
                type: "POST",
                url: "admin_zapisivanje_korisnika.php",
                dataType: "json",
                data: {"id":$("#korisnik").val(),"email":$("#email").val(),"aktivan":$("#aktivan").val(),"broj":parseInt($("#broj").val()),"dual":$("#dual").val()},
                success: function (podaci) {
                    if(podaci === "success"){
                        $("#error_status").html("Uspješno ste spremili postavke korisnika!");
                    }
                }
            });
        }
    });

});