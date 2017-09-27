$(document).ready(function(){

    var id_program = "";
    var id_kupon = "";
    var naziv_program = "";
    var naziv_kupon = "";

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    $.ajax({
        type: "GET",
        url: "mod_dohvacanje_programa.php",
        dataType: "json",
        data: {"aktivan":"DA"},
        success: function (podaci) {
            if(podaci !== "empty"){
                for (val of podaci) {
                    $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                }
                $.ajax({
                    type: "GET",
                    url: "mod_dohvacanje_kupona.php",
                    dataType: "json",
                    data: {"id":$("#program")[0].options[0].value,"exists":"DA"},
                    success: function (podaci) {
                        if(podaci !== "none"){
                            $("#error_status").html("");
                            $("#div_kupon").removeClass("skrij");
                            $("#gumbi").removeClass("skrij");
                            html = "";
                            for (val of podaci) {
                                html += "<option value=\"" + val.id + "\">" + val.naziv + "</option>";
                            }
                            $("#kupon").html(html);
                        }
                        else{
                            $("#error_status").html("Nema kupona definiranih za ovaj program!");
                            $("#div_kupon").addClass("skrij");
                            $("#gumbi").addClass("skrij");
                        }
                    }
                }); 
            }
        } 
    });

    $("#content").on("change", "#program", function () {

        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_kupona.php",
            dataType: "json",
            data: {"id":$("#program").val(),"exists":"DA"},
            success: function (podaci) {
                if(podaci !== "none"){
                    $("#error_status").html("");
                    $("#div_kupon").removeClass("skrij");
                    $("#gumbi").removeClass("skrij");
                    html = "";
                    for (val of podaci) {
                        html += "<option value=\"" + val.id + "\">" + val.naziv + "</option>";
                    }
                    $("#kupon").html(html);
                }
                else{
                    $("#error_status").html("Nema kupona definiranih za ovaj program!");
                    $("#div_kupon").addClass("skrij");
                    $("#gumbi").addClass("skrij");
                }
            }
        }); 
    });

    $("#content").on("click", "#ukloni", function(){

        naziv_program = $("#program option:selected").text();
        naziv_kupon = $("#kupon option:selected").text();

        id_kupon = $("#kupon").val();
        id_program = $("#program").val();
        
        $("#div_program").html("");
        $("#div_kupon").html("");
        $("#error_status").html("Jeste li sigurni da želite obrisati kupon <span class=\"podebljano\">" + naziv_kupon + "</span> za program <span class=\"podebljano\">" + naziv_program + "</span>?");
        $("#gumbi").html("<button class=\"gumb margin_top\" id=\"da\" type=\"button\">Da</button>&nbsp;&nbsp;<button class=\"gumb margin_top\" id=\"ne\" type=\"button\">Ne</button>");


    });

    $("#content").on("click", "#ukloni_sve", function(){

        naziv_program = $("#program option:selected").text();

        id_kupon = $("#kupon").val();
        id_program = $("#program").val();
        
        $("#div_program").html("");
        $("#div_kupon").html("");
        $("#error_status").html("Jeste li sigurni da želite obrisati sve kupone za program <span class=\"podebljano\">" + naziv_program + "</span>?");
        $("#gumbi").html("<button class=\"gumb margin_top\" id=\"da_all\" type=\"button\">Da</button>&nbsp;&nbsp;<button class=\"gumb margin_top\" id=\"ne_all\" type=\"button\">Ne</button>");

    });

    $("#content").on("click", "#ne", function () {
        location.reload();  
    });

    $("#content").on("click", "#ne_all", function () {
        location.reload();  
    });

    $("#content").on("click", "#da", function () {
        $.ajax({
            type: "GET",
            url: "mod_deaktiviranje_kupona.php",
            dataType: "json",
            data: {"kupon":id_kupon,"program":id_program,"all":"NE"},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#error_status").html("Uspješno ste deaktivirali kupon <span class=\"podebljano\">" + naziv_kupon + "</span>!");
                    $("#gumbi").html("<button class=\"gumb margin_top\" id=\"natrag\" type=\"button\">Natrag</button>");
                }
            }
        }); 
    });

    $("#content").on("click", "#da_all", function () {
        $.ajax({
            type: "GET",
            url: "mod_deaktiviranje_kupona.php",
            dataType: "json",
            data: {"kupon":id_kupon,"program":id_program,"all":"DA"},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#error_status").html("Uspješno ste deaktivirali sve kupone programa <span class=\"podebljano\">" + naziv_program + "</span>!");
                    $("#gumbi").html("<button class=\"gumb margin_top\" id=\"natrag\" type=\"button\">Natrag</button>");
                }
            }
        }); 
    });

    $("#content").on("click", "#natrag", function () {
        location.reload();  
    });

});