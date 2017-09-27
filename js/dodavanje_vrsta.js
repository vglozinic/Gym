$(document).ready(function(){

    flag_vrsta = false;

    $("#spremi").click(function(){

        if($("#vrsta").val() === ""){
            flag_vrsta = false;
            $("#vrsta").addClass("krivo");
            $("#error_vrsta").html("Naziv vrste nije unesen!");
        }
        else{
            if($("#vrsta").val().length <= 20 ){

                regex = /^[A-ZŠĐŽĆČ][A-ZŠĐŽĆČa-zšđžćč0-9 ]*$/;

                if(regex.test($("#vrsta").val())){
                    $.ajax({
                        async: false,
                        url: "admin_dohvacanje_vrsta.php",
                        method: "GET",
                        data: {"naziv": $("#vrsta").val()},
                        dataType: "json",
                        success: function(podaci) {
                            if(podaci === "exists") {
                                flag_vrsta = false;
                                $("#vrsta").addClass("krivo");
                                $("#error_vrsta").html("Ovakva vrsta već postoji!");                     
                            }
                            else{
                                flag_vrsta = true;
                                $("#vrsta").removeClass("krivo");
                                $("#error_vrsta").html("");
                                }
                            }
                    });
                }
                else{
                    flag_vrsta = false;
                    $("#vrsta").addClass("krivo");

                    regex = /[A-Z]/;

                    if(!regex.test($("#vrsta").val()[0])){
                        $("#error_vrsta").html("Naziv mora početi s velikim slovom!");  
                    }
                    else{
                        $("#error_vrsta").html("Naziv može sadržavati samo alfanumeričke znakove!");  
                    }  
                }
            }
            else{
                flag_vrsta = false;
                $("#vrsta").addClass("krivo");
                $("#error_vrsta").html("Naziv mora biti kraći od 20 znakova!");
            }
        }

        if(flag_vrsta){

            $.ajax({
                url: "admin_zapisivanje_vrste.php",
                method: "GET",
                data: {"naziv": $("#vrsta").val()},
                dataType: "json",
                success: function(podaci) {
                    if(podaci === "success") {
                        $("#error_status").html("Uspješno ste dodali vrstu!");
                    }
                    else{
                        $("#error_status").html("Dogodila se pogreška."); 
                        }
                    }
            });
        }
        else{
            $("#error_status").html("");
        }
    });
    
});