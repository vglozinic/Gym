$(document).ready(function(){

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    $.ajax({
        type: "GET",
        url: "admin_dohvacanje_programa.php",
        dataType: "json",
        data: {"aktivan":$("input:radio:checked").val()},
        success: function (podaci) {
            if(podaci !== "error"){
                for (val of podaci) {
                    $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                }
                $("#error_program").html("<span class=\"podebljano\">Trener:</span> " + podaci[0].ime + " " + podaci[0].prezime);
                $.ajax({
                    type: "GET",
                    url: "admin_dohvacanje_mzp.php",
                    dataType: "json",
                    data: {"id":$("#program")[0].options[0].value},
                    success: function (podaci) {
                        if(!jQuery.isEmptyObject(podaci)){
                            for (val of podaci.dostupno) {
                                $("#moderator").append("<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>")
                            }
                            $("#error_program").html("<span class=\"podebljano\">Trener:</span> " + podaci.trener.ime + " " + podaci.trener.prezime);
                        }
                    }
                }); 
            }
        } 
    });

    $("input:radio").change(function (){
        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_programa.php",
            dataType: "json",
            data: {"aktivan":$("input:radio:checked").val()},
            success: function (podaci) {
                if(podaci !== "error"){
                    string = "";
                    for (val of podaci) {
                        string += "<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>";
                    }
                    $("#program").html(string);
                    $("#error_program").html("<span class=\"podebljano\">Trener:</span> " + podaci[0].ime + " " + podaci[0].prezime);
                    $.ajax({
                        type: "GET",
                        url: "admin_dohvacanje_mzp.php",
                        dataType: "json",
                        data: {"id":$("#program")[0].options[0].value},
                        success: function (podaci) {
                            if(!jQuery.isEmptyObject(podaci)){
                                string = "";
                                for (val of podaci.dostupno) {
                                    string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                                }
                                $("#moderator").html(string);
                                $("#error_program").html("<span class=\"podebljano\">Trener:</span> " + podaci.trener.ime + " " + podaci.trener.prezime);
                            }
                        }
                    }); 
                }
            } 
        });
    })

    $("#program").change(function () {

        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_mzp.php",
            dataType: "json",
            data: {"id":$("#program").val()},
            success: function (podaci) {
                if(!jQuery.isEmptyObject(podaci)){
                    string = "";
                    for (val of podaci.dostupno) {
                        string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                    }
                    $("#moderator").html(string);
                    $("#error_program").html("<span class=\"podebljano\">Trener:</span> " + podaci.trener.ime + " " + podaci.trener.prezime);
                }
            }
        });
    });

    $("#zamijeni").click(function () {

        $.ajax({
            type: "GET",
            url: "admin_zamijeni_moderatora.php",
            dataType: "json",
            data: {"program": $("#program").val(),"korisnik": $("#moderator").val()},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#error_status").html("Uspješno je zamijenjen moderator!");
                    $.ajax({
                        type: "GET",
                        url: "admin_dohvacanje_mzp.php",
                        dataType: "json",
                        data: {"id":$("#program").val()},
                        success: function (podaci) {
                            if(!jQuery.isEmptyObject(podaci)){
                                string = "";
                                for (val of podaci.dostupno) {
                                    string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                                }
                                $("#moderator").html(string);
                                $("#error_program").html("<span class=\"podebljano\">Trener:</span> " + podaci.trener.ime + " " + podaci.trener.prezime);
                            }
                        }
                    }); 
                }
            }
        });
    });  

    $("#zamijeni_sve").click(function () {

        $.ajax({
            type: "GET",
            url: "admin_zamijeni_moderatora.php",
            dataType: "json",
            data: {"program": $("#program").val(),"korisnik": $("#moderator").val(),"all":"ALL"},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#error_status").html("Uspješno su zamijenjeni moderatori!");
                    $.ajax({
                        type: "GET",
                        url: "admin_dohvacanje_mzp.php",
                        dataType: "json",
                        data: {"id":$("#program").val()},
                        success: function (podaci) {
                            if(!jQuery.isEmptyObject(podaci)){
                                string = "";
                                for (val of podaci.dostupno) {
                                    string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                                }
                                $("#moderator").html(string);
                                $("#error_program").html("<span class=\"podebljano\">Trener:</span> " + podaci.trener.ime + " " + podaci.trener.prezime);
                            }
                        }
                    }); 
                }
            }
        });
    });  

});