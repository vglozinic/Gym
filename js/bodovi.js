$(document).ready(function () {

    var stranica = 1;
    var ukupno = 0;

    var radnja = "";
    var order = "";

    function bodovi() {
        $.ajax({
            type: "GET",
            url: "user_dohvacanje_bodova.php",
            data: {"stranica": stranica,"zapisi": zapis,"radnja":$("#radnja").val(),"order":$("#order").val()},
            dataType: "json",
            success: function (podaci) {
                var radnjahtml = "";
                var table = "";
                var stranicenje = "";
                $("#stanje").html("Trenutno stanje bodova je: " + podaci.broj);
                if (!jQuery.isEmptyObject(podaci.statistika)) {
                    radnjahtml += "<option value=\"All\">Sve</option>";
                    for(var i = 0; i < podaci.radnje.length; i++) {
                        radnjahtml += "<option value=\"" + podaci.radnje[i] + "\">" + podaci.radnje[i] + "</option>";
                    }
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Radnja</th><th>Bodovi</th><th>Datum</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.statistika.length; i++) {
                        table += "<tr>";
                        table += "<td>" +  podaci.statistika[i].radnja + "</td>";
                        table += "<td>" +  podaci.statistika[i].broj + "</td>";
                        table += "<td>" +  podaci.statistika[i].datum.substring(8, 10) + "." + podaci.statistika[i].datum.substring(5, 7) + "." + podaci.statistika[i].datum.substring(0, 4) + ".</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    if(podaci.zbroj != 0) {
                        table += "Ukupni zbroj bodova za ovu radnju je: " + podaci.zbroj;
                    } 
                    ukupno = Math.ceil(podaci.ukupno/zapis);

                    if (ukupno > 5){
                        stranicenje += "<button class=\"gumb lijevo\"><<</button><button class=\"gumb natrag\"><</button>";
                        if (stranica == 1){
                            for (i = stranica; i <= (stranica + 4); i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else if (stranica == 2){
                            for (i = stranica-1; i <= (stranica + 3); i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else if (stranica == (ukupno - 1)){
                            for (i = stranica - 3; i <= ukupno; i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else if (stranica == ukupno){
                            for (i = stranica - 4; i <= ukupno; i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else{
                            for (i = stranica - 2; i <= (stranica + 2); i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        stranicenje += "<button class=\"gumb naprijed\">></button><button class=\"gumb desno\">>></button>";
                    }
                    else{
                        for (i = 1; i <= ukupno; i++) {
                            stranicenje += "<button class=\"gumb stranica";
                            if (i == stranica) {
                                stranicenje += " pushed";
                            }
                            stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                        }
                    }

                    $("#radnja").html(radnjahtml);
                    $("#tablica").html(table);
                    $("#stranicenje").html(stranicenje);
                    
                    if (radnja != "") {
                        $("#radnja").val(radnja);
                    }

                    if (order != "") {
                        $("#order").val(order);
                    }
                }
            }
        });
    }

    bodovi();

    $("#stranicenje").on("click", ".stranica", function () {
        stranica = parseInt($(this)[0].id);
        bodovi();
    });

    $("#stranicenje").on("click", ".lijevo", function () {
        stranica = 1;
        bodovi();
    });

    $("#stranicenje").on("click", ".desno", function () {
        stranica = ukupno;
        bodovi();
    });

    $("#stranicenje").on("click", ".natrag", function () {
        if ((stranica - 1) > 0){
            stranica -= 1;
            bodovi();
        }
    });

    $("#stranicenje").on("click", ".naprijed", function () {
        if ((stranica + 1) <= ukupno){
            stranica += 1;
            bodovi();
        }
    });

    $("#content").on("change", "#radnja", function(){
        radnja = $(this).val();
        stranica = 1;
        bodovi();
    });

    $("#content").on("change", "#order", function(){
        order = $(this).val();
        stranica = 1;
        bodovi();
    });
    
});