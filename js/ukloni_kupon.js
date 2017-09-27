$(document).ready(function(){

    $.ajax({
        type: "GET",
        url: "admin_dohvacanje_kupona.php",
        dataType: "json",
        success: function (podaci) {
            if (!jQuery.isEmptyObject(podaci)) {
                for(val of podaci) {
                    $("#kupon").append("<option value=\"" + val.id + "\">" + val.naziv + "</option>");
                }

            }
            else {
                $("#error_status").html("Ne postoji ni jedan kupon.");
            } 
        } 
    });

    $("#ukloni").click(function(){

        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_kupona.php",
            dataType: "json",
            data:{"check":"yes","id":$("#kupon").val()},
            success: function (podaci) {
                if (podaci === "exists") {
                    $("#error_status").html("Kupon je dodijeljen programu!");
                }
                else {
                    $.ajax({
                        type: "GET",
                        url: "admin_brisanje_kupona.php",
                        dataType: "json",
                        data:{"id":$("#kupon").val()},
                        success: function (podaci) {
                            if (podaci === "success") {
                                $("#error_status").html("Kupon je uspješno izbrisan!");
                                $.ajax({
                                    type: "GET",
                                    url: "admin_dohvacanje_kupona.php",
                                    dataType: "json",
                                    success: function (podaci) {
                                        if (!jQuery.isEmptyObject(podaci)) {
                                            string = "";
                                            for(val of podaci) {
                                                string += "<option value=\"" + val.id + "\">" + val.naziv + "</option>";
                                            }
                                            $("#kupon").html(string);
                                        }
                                        else {
                                            $("#error_status").html("Ne postoji ni jedan kupon.");
                                        } 
                                    } 
                                });
                            }
                        } 
                    });
                } 
            } 
        });

    });

});