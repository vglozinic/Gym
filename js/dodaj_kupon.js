$(document).ready(function(){

    flag_naziv = false;

    $("#naziv").focusout(function (){

        if($("#naziv").val() === ""){
            flag_vrsta = false;
            $("#naziv").addClass("krivo");
            $("#error_naziv").html("Naziv kupona nije unesen!");
        }
        else{
            if($("#naziv").val().length <= 100){

                regex = /^[A-ZŠĐŽĆČ][A-ZŠĐŽĆČa-zšđžćč0-9%\-!.,* ]*$/;

                if(regex.test($("#naziv").val())){
                    $.ajax({
                        async: false,
                        url: "provjera_kupon.php",
                        method: "GET",
                        data: {"kupon": $("#naziv").val()},
                        dataType: "json",
                        success: function(podaci) {
                            if(podaci === "exists") {
                                flag_naziv = false;
                                $("#naziv").addClass("krivo");
                                $("#error_naziv").html("Kupon ovog naziva već postoji!");                     
                            }
                            else{
                                flag_naziv = true;
                                $("#naziv").removeClass("krivo");
                                $("#error_naziv").html("");
                                }
                            }
                    });
                }
                else{
                    flag_vrsta = false;
                    $("#naziv").addClass("krivo");

                    regex = /[A-ZŠĐŽĆČ]/;

                    if(!regex.test($("#naziv").val()[0])){
                        $("#error_naziv").html("Naziv mora početi s velikim slovom!");  
                    }
                    else{
                        $("#error_naziv").html("Naziv mora sadržavati slova, brojke i specijalne znakove (% - ! . , *)!");  
                    }  
                }
            }
            else{
                flag_vrsta = false;
                $("#naziv").addClass("krivo");
                $("#error_naziv").html("Naziv ne smije biti veći od 100 znakova!");
            }
        }
    
    });
    
    $("#kupform").submit(function(event){

        $("#naziv").blur();

        if(!flag_naziv){
            event.preventDefault();
        }

    });
});