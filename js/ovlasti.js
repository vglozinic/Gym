$(document).ready(function(){

    $.ajax({
        type: "GET",
        url: "admin_dohvacanje_moderatora.php",
        dataType: "json",
        success: function (podaci) {
            if (!jQuery.isEmptyObject(podaci)) {
                for(val of podaci) {
                    $("#moderator").append("<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>");
                }
            }
            else {
                $("#content").html("<h2>Uklanjanje ovlasti</h2>Ne postoji niti jedan moderator.<br><a href=\"a_moderatori.php\"><button class=\"gumb margin_top\">Natrag</button></a>");  
            } 
        } 
    });

    $("#makni").click(function () {

        $.ajax({
            type: "GET",
            url: "admin_micanje_ovlasti.php",
            dataType: "json",
            data: {"moderator": $("#moderator").val()},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#error_status").html("Uspješno ste maknuli moderatoru ovlasti!");
                    $.ajax({
                        type: "GET",
                        url: "admin_dohvacanje_moderatora.php",
                        dataType: "json",
                        success: function (podaci) {
                            if (!jQuery.isEmptyObject(podaci)) {
                                html = "";
                                for(val of podaci) {
                                    html += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                                }
                                $("#moderator").html(html);
                            }
                            else{
                                $("#content").html("<h2>Uklanjanje ovlasti</h2>Ne postoji niti jedan moderator.<br><a href=\"a_moderatori.php\"><button class=\"gumb margin_top\">Natrag</button></a>");  
                            } 
                        } 
                    });
                }
                else{
                    $("#error_status").html("Moderator je trener postojećeg programa!");
                }
            }
        });
    });  

});