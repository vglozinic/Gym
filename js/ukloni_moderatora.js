$(document).ready(function(){

    $.ajax({
        type: "GET",
        url: "dohvacanje_vrsta.php",
        dataType: "json",
        success: function (podaci) {
            if(podaci !== "error"){
                for (val of podaci) {
                    $("#vrsta").append("<option value=\"" + val.id_vrsta + "\">" + val.naziv + "</option>");
                }
                $.ajax({
                    type: "GET",
                    url: "admin_dohvacanje_mzv.php",
                    dataType: "json",
                    data: {"id":$("#vrsta")[0].options[0].value},
                    success: function (podaci) {
                        if(!jQuery.isEmptyObject(podaci)){
                            string = "";
                            for (val of podaci) {
                             string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                            }
                            $("#moderator").html(string);
                        }
                        else{
                            $("#div_moderator").html("Nema zapisa za ovu vrstu programa!");
                        }
                    }
                }); 
            }
        } 
    });

    $("#vrsta").change(function () {

        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_mzv.php",
            dataType: "json",
            data: {"id":$("#vrsta").val()},
            success: function (podaci) {
                if(!jQuery.isEmptyObject(podaci)){
                    string = "<label class=\"label_prijava\" for=\"moderator\"><span class=\"podebljano\">Moderator</span></label>";
                    string += "<br>";
                    string += "<select id=\"moderator\" name=\"Moderator\" class=\"input\">"
                    for (val of podaci) {
                        string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                    }
                    string += "</select>";
                    $("#div_moderator").html(string);
                }
                else{
                    $("#div_moderator").html("Nema zapisa za ovu vrstu programa!");
                }
            }
        }); 
    });

    $("#ukloni").click(function () {

        $.ajax({
            type: "GET",
            url: "admin_ukloni_moderatora.php",
            dataType: "json",
            data: {"vrsta": $("#vrsta").val(), "moderator": $("#moderator").val()},
            success: function (podaci) {
                if(podaci === "error"){
                    $("#error_status").html("Moderator je trener postojećeg programa!");
                }
                else{
                    $("#error_status").html("Uspješno ste uklonili moderatora!");
                    $.ajax({
                        type: "GET",
                        url: "admin_dohvacanje_mzv.php",
                        dataType: "json",
                        data: {"id":$("#vrsta").val()},
                        success: function (podaci) {
                            if(!jQuery.isEmptyObject(podaci)){
                                string = "<label class=\"label_prijava\" for=\"moderator\"><span class=\"podebljano\">Moderator</span></label>";
                                string += "<br>";
                                string += "<select id=\"moderator\" name=\"Moderator\" class=\"input\">"
                                for (val of podaci) {
                                    string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                                }
                                string += "</select>";
                                $("#div_moderator").html(string);
                            }
                            else{
                                $("#div_moderator").html("Nema zapisa za ovu vrstu programa!");
                            }
                        }
                    }); 
                }
            }
        });
    });  

});