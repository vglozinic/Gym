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
            }
        } 
    });

    $("#ukloni").click(function () {

        $.ajax({
            type: "GET",
            url: "admin_ukloni_vrstu.php",
            dataType: "json",
            data: {"id": $("#vrsta").val()},
            success: function (podaci) {
                if(podaci === "error"){
                    $("#error_status").html("Postoje programi i treneri za ovu vrstu!");
                }
                else{
                    $("#error_status").html("Uspješno ste uklonili vrstu!");
                    $.ajax({
                        type: "GET",
                        url: "dohvacanje_vrsta.php",
                        dataType: "json",
                        success: function (podaci) {
                            if(podaci !== "error"){
                                string = ""
                                for (val of podaci) {
                                    string += "<option value=\"" + val.id_vrsta + "\">" + val.naziv + "</option>";
                                }
                                $("#vrsta").html(string);
                            }
                        } 
                    }); 
                }
            }
        });
    });  

});