$(document).ready(function(){

    $.ajax({
        type: "GET",
        url: "admin_dohvacanje_korisnika.php",
        dataType: "json",
        success: function (podaci) {
            if(podaci !== "empty"){
                for (val of podaci) {
                    $("#korisnik").append("<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>");
                }
            }
            else{
                 $("#div_korisnik").html("Ne postoji niti jedan registrirani korisnik!");
            }
        } 
    });

    $("#dodaj").click(function () {

        $.ajax({
            type: "GET",
            url: "admin_zapisi_moderatora.php",
            dataType: "json",
            data: {"id": $("#korisnik").val()},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#error_status").html("Uspješno ste dodali moderatora!");
                    $.ajax({
                        type: "GET",
                        url: "admin_dohvacanje_korisnika.php",
                        dataType: "json",
                        success: function (podaci) {
                            if(podaci !== "empty"){
                                string = "";
                                for (val of podaci) {
                                    string += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                                }
                                $("#korisnik").html(string);
                            }
                            else{
                                $("#div_korisnik").html("Ne postoji niti jedan registrirani korisnik!");
                            }
                        } 
                    });
                }
                else{
                    $("#error_status").html("");
                }
            }
        });
    });   

});