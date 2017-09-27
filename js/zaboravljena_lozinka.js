$(document).ready(function(){

    flag_username = false;

    $("#username").focusout(function () {

        if($("#username").val() === ""){
            flag_username = false;
            $("#username").addClass("krivo");
            $("#error_username").html("Korisničko ime nije uneseno!");
        }
        else{
            if($("#username").val().length >= 8 && $("#username").val().length <= 25 ){

                regex = /^[a-z0-9][a-z0-9.\-_]*[a-z0-9]$/;

                if(regex.test($("#username").val())){
                    flag_username = true;
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

    $("#posalji").click(function () {
        $("#username").blur();
        if (flag_username) {
             $.ajax({
                    async: false,
                    url: "provjera_username.php",
                    method: "GET",
                    data: {"username": $("#username").val()},
                    dataType: "json",
                    success: function(podaci) {
                        if(podaci === "taken") {
                            $("#username").removeClass("krivo");
                            $("#error_username").html("");
                            $.ajax({
                                type: "get",
                                url: "posalji_lozinku.php",
                                data: {username: $("#username").val()},
                                dataType: "json",
                                success: function (podaci) {
                                    $("#content").html("<br>Nova lozinka vam je poslana na E-mail!<br><br>");
                                }
                            });
                        }
                        else{
                            flag_username = false;
                            $("#username").addClass("krivo");
                            $("#error_username").html("Korisničko ime ne postoji!");
                        }
                    }
                });
        }
    });
});