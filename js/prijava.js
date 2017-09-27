$(document).ready(function () {
    var flag_username = false;
    var flag_lozinka = false;
    var flag_kod = true;

    function checkLength(value, lowest, highest){
        if((value.length >= lowest) && (value.length <= highest)){
            return true;
        }
        else{
            return false;
        }
    }

    $("#username").focusout(function() {

        if($("#username").val() === ""){
            flag_username = false;
            $("#username").addClass("krivo");
            $("#error_username").html("Korisničko ime nije uneseno!");
        }
        else{
            if(checkLength($("#username").val(),8,25)){

                regex = /^[a-z0-9][a-z0-9.\-_]*[a-z0-9]$/;

                if(regex.test($("#username").val())){

                    $.ajax({
                        async: false,
                        type: "GET",
                        url: "provjera_login.php",
                        data: {"username": $("#username").val()},
                        dataType: "json",
                        success: function (podaci) {
                            if(podaci === "none"){
                                flag_username = false;
                                $("#username").addClass("krivo");
                                $("#error_username").html("Korisničko ime ne postoji!");
                            }
                            else{
                                $("#username").removeClass("krivo");
                                $("#error_username").html("");
                                if(podaci.aktivan === "DA"){
                                    if(podaci.zabranjen === "NE"){
                                        flag_username = true;
                                        $("#error_status").html("");
                                    }
                                    else{
                                        flag_username = false;
                                        $("#error_status").html("Zabranjen vam je pristup. Kontaktirajte administratora.");
                                    }
                                }
                                else{
                                    flag_username = false;
                                    $("#error_status").html("Niste aktivirali svoj korisnički račun!");
                                }
                            }
                        }
                    });

                }
                else{
                    regex = /[a-z0-9]/;
                    if(regex.test($("#username").val()[$("#username").val().length-1]) && regex.test($("#username").val()[0])){
                        flag_username = false;
                        $("#username").addClass("krivo");
                        $("#error_username").html("Korisničko ime može sadržavati mala slova, brojke, crticu, točku i podvlaku!");
                    }
                    else{
                        flag_username = false;
                        $("#username").addClass("krivo");
                        $("#error_username").html("Korisničko ime mora počinjati i završavati malim slovom ili brojkom!");
                    }
                }
            }
            else{
                flag_username = false;
                $("#username").addClass("krivo");
                $("#error_username").html("Korisničko ime mora biti između 8 i 25 znakova!");
            }
        }
    });

    $("#lozinka").focusout(function() {
        if($("#lozinka").val() === ""){
            flag_lozinka = false;
            $("#lozinka").addClass("krivo");
            $("#error_lozinka").html("Lozinka nije unesena!");
        }
        else{
            if(checkLength($("#lozinka").val(),8,50)){

                regex = /^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/;

                if(regex.test($("#lozinka").val())){
                    flag_lozinka = true;
                    $("#lozinka").removeClass("krivo");
                    $("#error_lozinka").html("");
                }
                else{
                    regex = /[A-Za-z0-9]/;
                    if(regex.test($("#lozinka").val()[$("#lozinka").val().length-1]) && regex.test($("#lozinka").val()[0])){
                        flag_lozinka = false;
                        $("#lozinka").addClass("krivo");
                        $("#error_lozinka").html("Lozinka može sadržavati mala i velika slova, brojke, podvlaku i crticu!");
                    }
                    else{
                        flag_lozinka = false;
                        $("#lozinka").addClass("krivo");
                        $("#error_lozinka").html("Lozinka mora počinjati i završavati slovom ili brojkom!");
                    }
                }

            }
            else{
                flag_lozinka = false;
                $("#lozinka").addClass("krivo");
                $("#error_lozinka").html("Lozinka mora biti između 8 i 50 znakova!");
            }
        }
    });

    $("#kod").focusout(function () {
        if($("#kod").val() === ""){
            flag_kod = false;
            $("#kod").addClass("krivo");
            $("#error_kod").html("Kod za prijavu nije unesen!");
        }
        else{
            if($("#kod").val().length != 5){
                flag_kod = false;
                $("#kod").addClass("krivo");
                $("#error_kod").html("Broj znakova u kodu nije ispravan!");
            }
            else{
                regex = /^[A-Z0-9]{5}$/;
                if(regex.test($("#kod").val())){
                    flag_kod = true;
                    $("#error_kod").html("");
                    $("#kod").removeClass("krivo");
                }
                else{
                    flag_kod = false;
                    $("#error_kod").html("Kod može sadržavati samo velika slova i brojeve!");
                    $("#kod").addClass("krivo");
                }
            }
        }
    });

    $("#forma_prijava").submit(function (event) {

        $("#username").blur();
        $("#lozinka").blur();
        $("#kod").blur();

        if (!flag_username || !flag_lozinka || !flag_kod) {
            event.preventDefault();
        }
    });
});