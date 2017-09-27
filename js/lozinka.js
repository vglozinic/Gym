$(document).ready(function(){

    var flag_OK = false;
    var flag_lozinka = false;
    var flag_nova = false;
    var flag_potvrda = false;

    $("#lozinka").focusout(function() {
        if($("#lozinka").val() === ""){
            flag_lozinka = false;
            $("#lozinka").addClass("krivo");
            $("#error_lozinka").html("Trenutna lozinka nije unesena!");
        }
        else{
            if($("#lozinka").val().length >= 8 && $("#lozinka").val().length <= 50){

                regex = /^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/;

                if(regex.test($("#lozinka").val())){
                    flag_lozinka = true;
                    $("#lozinka").removeClass("krivo");
                    $("#error_lozinka").html("");
                }
                else{
                    flag_lozinka = false;
                    $("#lozinka").addClass("krivo");

                    regex = /[A-Za-z0-9]/;

                    if(regex.test($("#lozinka").val()[$("#lozinka").val().length-1]) && regex.test($("#lozinka").val()[0])){
                        $("#error_lozinka").html("Trenutna lozinka može sadržavati mala i velika slova, brojke, podvlaku i crticu!");
                    }
                    else{
                        $("#error_lozinka").html("Trenutna lozinka mora počinjati i završavati slovom ili brojkom!");
                    }
                }
                
            }
            else{
                flag_lozinka = false;
                $("#lozinka").addClass("krivo");
                $("#error_lozinka").html("Trenutna lozinka mora biti između 8 i 50 znakova!");
            }
        }
    });

    $("#nova").focusout(function(){
        if($("#nova").val() === ""){
            flag_nova = false;
            $("#nova").addClass("krivo");
            $("#error_nova").html("Nova lozinka nije unesena!");
        }
        else{
            if($("#nova").val().length >= 8 && $("#nova").val().length <= 50){

                regex = /^[A-Za-z0-9][A-Za-z0-9\-_]*[A-Za-z0-9]$/;

                if(regex.test($("#nova").val())){
                    flag_nova = true;
                    $("#nova").removeClass("krivo");
                    $("#error_nova").html("");
                }
                else{
                    flag_nova = false;
                    $("#nova").addClass("krivo");

                    regex = /[A-Za-z0-9]/;

                    if(regex.test($("#nova").val()[$("#nova").val().length-1]) && regex.test($("#nova").val()[0])){
                        $("#error_nova").html("Nova lozinka može sadržavati mala i velika slova, brojke, podvlaku i crticu!");
                    }
                    else{
                        $("#error_nova").html("Nova lozinka mora počinjati i završavati slovom ili brojkom!");
                    }
                }
            }
            else{
                flag_nova = false;
                $("#nova").addClass("krivo");
                $("#error_nova").html("Nova lozinka mora biti između 8 i 50 znakova!");
            }
        }
    });

    $("#potvrda").focusout(function() {
        if($("#potvrda").val() === ""){
            flag_potvrda = false;
            $("#potvrda").addClass("krivo");
            $("#error_potvrda").html("Potvrda nove lozinke nije unesena!");
        }
        else{
            if($("#potvrda").val() === $("#nova").val()){
                flag_potvrda = true;
                $("#potvrda").removeClass("krivo");
                $("#error_potvrda").html("");
            }
            else{
                flag_potvrda = false;
                $("#potvrda").addClass("krivo");
                $("#error_potvrda").html("Potvrda nove lozinke nije ispravna!");
            }
        }
    });

    $("#forma_promjena").submit(function(event){

        $("#lozinka").blur();
        $("#nova").blur();
        $("#potvrda").blur();

        if(flag_lozinka && flag_potvrda && flag_nova) {
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