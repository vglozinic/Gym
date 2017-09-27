$(document).ready(function(){

    flag_kod = false;

    $("#kod").focusout(function (){

        if($("#kod").val() === ""){
            flag_kod = false;
            $("#kod").addClass("krivo");
            $("#error_kod").html("Kod kupona nije unesen!");
        }
        else{
            if($("#kod").val().length == 10){

                regex = /^[0-9]*$/;

                if(regex.test($("#kod").val())){
                    flag_kod = true;
                    $("#kod").removeClass("krivo");
                    $("#error_kod").html("");
                }
                else{
                    flag_kod = false;
                    $("#kod").addClass("krivo");
                    $("#error_kod").html("Kod mora sadržavati 10 znamenaka!");
                }
            }
            else{
                flag_kod = false;
                $("#kod").addClass("krivo");
                $("#error_kod").html("Kod mora sadržavati 10 znamenaka!");
            }
        }
    
    });
    
    $("#provjeri").click(function(){

        $("#kod").blur();

        if(flag_kod){
            $.ajax({
                async: false,
                url: "provjera_kod.php",
                method: "GET",
                data: {"kod": $("#kod").val()},
                dataType: "json",
                success: function(podaci) {
                    if(podaci === "exists") {
                        $("#error_status").html("Kod kupona postoji!");                  
                    }
                    else{
                        $("#error_status").html("Kod kupona ne postoji!");
                        }
                    }
            });
        }
    });

});