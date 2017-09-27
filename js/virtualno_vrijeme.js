$(document).ready(function(){

    $("#dohvati").click(function () {
        $.ajax({
            url: "https://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=json",
            method: "GET",
            dataType: "json",
            success: function(podaci) {
                $.ajax({
                    type: "GET",
                    url: "admin_postavi_vrijeme.php",
                    data: {pomak: parseInt(podaci.WebDiP.vrijeme.pomak.brojSati)},
                    dataType: "json",
                    success: function (podaci) {
                        $("#content").html("<br>Pomak vremena u satima je postavljen na: " + podaci + "<br><br>");
                    }
                });
            }
        });
    });
});