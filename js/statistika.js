$(document).ready(function () {
    var stranica = 1;
    var ukupno = 0;

    var radnja = "";
    var korisnik = "";
    var order = "";
    var datum = "";
    var points = "";
    var operator = ">";

    function bodovi(operator) {
        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_statistike.php",
            data: {"stranica": stranica,"zapisi": zapis,"radnja":$("#radnja").val(),"korisnik":$("#korisnik").val(),"order":$("#order").val(),"operator":operator,"datum":$("#datum").val()},
            dataType: "json",
            success: function (podaci) {
                var radnjahtml = "";
                var korisnikhtml = "";
                var orderhtml = "";
                var table = "";
                var stranicenje = "";
                if (!jQuery.isEmptyObject(podaci.statistika)) {
                    radnjahtml += "<option value=\"All\">Sve</option>";
                    for(var i = 0; i < podaci.radnje.length; i++) {
                        radnjahtml += "<option value=\"" + podaci.radnje[i] + "\">" + podaci.radnje[i] + "</option>";
                    }
                    korisnikhtml += "<option value=\"all\">Svi</option>";
                    for(var i = 0; i < podaci.korisnici.length; i++) {
                        korisnikhtml += "<option value=\"" + podaci.korisnici[i].username + "\">" + podaci.korisnici[i].ime + " " + podaci.korisnici[i].prezime + "</option>";
                    }
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Radnja</th><th>Datum</th><th>Korisnik</th><th>Bodovi</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.statistika.length; i++) {
                        table += "<tr>";
                        table += "<td>" +  podaci.statistika[i].radnja + "</td>";
                        table += "<td>" +  podaci.statistika[i].datum.substring(8, 10) + "." + podaci.statistika[i].datum.substring(5, 7) + "." + podaci.statistika[i].datum.substring(0, 4) + ".</td>";
                        table += "<td>" +  podaci.statistika[i].ime + " " + podaci.statistika[i].prezime + "</td>";
                        if(podaci.statistika[i].broj < 0){
                            table += "<td>" +  podaci.statistika[i].broj.substring(1, podaci.statistika[i].broj.length) + "</td>";
                        }
                        else{
                            table += "<td>" +  podaci.statistika[i].broj + "</td>";
                        }
                        table += "</tr>";
                    }
                    table += "</table>";
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

                    if(operator === ">"){
                        orderhtml += "<option value=\"DESC\">Najviše</option>";
                        orderhtml += "<option value=\"ASC\">Najmanje</option>";
                    }
                    else{
                        orderhtml += "<option value=\"ASC\">Najviše</option>";
                        orderhtml += "<option value=\"DESC\">Najmanje</option>";
                    }

                    $("#radnja").html(radnjahtml);
                    $("#korisnik").html(korisnikhtml)
                    $("#order").html(orderhtml);
                    $("#tablica_bodovi").html(table);
                    $("#stranicenje_bodovi").html(stranicenje);
                    
                    if (radnja != "") {
                        $("#radnja").val(radnja);
                    }
                    if (korisnik != "") {
                        $("#korisnik").val(korisnik);
                    }
                    if (order != "") {
                        $("#order").val(order);
                    }
                }
                else {
                    $("#tablica_bodovi").html("Ne postoji zapis u statistici lojalnosti.");
                    $("#stranicenje_bodovi").html("");
                }
            }
        });
    }

    function korisnici() {
        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_kzb.php",
            data: {"stranica": stranica,"zapisi": zapis,"order":$("#points").val()},
            dataType: "json",
            success: function (podaci) {
                var table = "";
                var stranicenje = "";
                if (!jQuery.isEmptyObject(podaci)) {
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Ime</th><th>Prezime</th><th>Korisničko ime</th><th>E-mail</th><th>Broj bodova</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.korisnici.length; i++) {
                        table += "<tr>";
                        table += "<td>" +  podaci.korisnici[i].ime + "</td>";
                        table += "<td>" +  podaci.korisnici[i].prezime + "</td>";
                        table += "<td>" +  podaci.korisnici[i].username + "</td>";
                        table += "<td>" +  podaci.korisnici[i].email + "</td>";
                        table += "<td>" +  podaci.korisnici[i].broj_bodova + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
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
                    $("#tablica_korisnici").html(table);
                    $("#stranicenje_korisnici").html(stranicenje);
                }
                else {
                    $("#tablica_korisnici").html("Ne postoji zapis u ovoj pretrazi.");
                    $("#stranicenje_korisnici").html("");
                }
            }
        });
    }

    bodovi(operator);

    $("#stranicenje_bodovi").on("click", ".stranica", function () {
        stranica = parseInt($(this)[0].id);
        bodovi(operator);
    });

    $("#stranicenje_bodovi").on("click", ".lijevo", function () {
        stranica = 1;
        bodovi(operator);
    });

    $("#stranicenje_bodovi").on("click", ".desno", function () {
        stranica = ukupno;
        bodovi(operator);
    });

    $("#stranicenje_bodovi").on("click", ".natrag", function () {
        if ((stranica - 1) > 0){
            stranica -= 1;
            bodovi(operator);
        }
    });

    $("#stranicenje_bodovi").on("click", ".naprijed", function () {
        if ((stranica + 1) <= ukupno){
            stranica += 1;
            bodovi(operator);
        }
    });

    $("#stranicenje_korisnici").on("click", ".stranica", function () {
        stranica = parseInt($(this)[0].id);
        korisnici();
    });

    $("#stranicenje_korisnici").on("click", ".lijevo", function () {
        stranica = 1;
        korisnici();
    });

    $("#stranicenje_korisnici").on("click", ".desno", function () {
        stranica = ukupno;
        korisnici();
    });

    $("#stranicenje_korisnici").on("click", ".natrag", function () {
        if ((stranica - 1) > 0){
            stranica -= 1;
            korisnici();
        }
    });

    $("#stranicenje_korisnici").on("click", ".naprijed", function () {
        if ((stranica + 1) <= ukupno){
            stranica += 1;
            korisnici();
        }
    });

    $("#content").on("change", "#radnja", function(){
        radnja = $(this).val();
        stranica = 1;
        bodovi(operator);
    });

    $("#content").on("change", "#korisnik", function (){
        korisnik = $(this).val();
        stranica = 1;
        bodovi(operator);
    });

    $("#content").on("change", "#datum", function (){
        datum = $(this).val();
        stranica = 1;
        bodovi(operator);
    });

    $("#content").on("change", "#order", function () {
        order = $(this).val();
        stranica = 1;
        bodovi(operator);
    });

    $("#content").on("change", "#points", function (){
        stranica = 1;
        points = $(this).val();
        korisnici();
    });

    $("#skupljeno").click(function (){
        stranica = 1;
        $("#div_bodovi").removeClass("skrij");
        $("#div_korisnici").addClass("skrij");
        operator = ">";
        bodovi(operator);
        $("#skupljeno").addClass("pushed");
        $("#korisnici").removeClass("pushed");
        $("#potroseno").removeClass("pushed");
    });

    $("#potroseno").click(function (){
        stranica = 1;
        $("#div_bodovi").removeClass("skrij");
        $("#div_korisnici").addClass("skrij");
        operator = "<";
        bodovi(operator);
        $("#potroseno").addClass("pushed");
        $("#korisnici").removeClass("pushed");
        $("#skupljeno").removeClass("pushed");
    });

    $("#korisnici").click(function (){
        stranica = 1;
        $("#div_korisnici").removeClass("skrij");
        $("#div_bodovi").addClass("skrij");
        korisnici();
        $("#korisnici").addClass("pushed");
        $("#potroseno").removeClass("pushed");
        $("#skupljeno").removeClass("pushed");
    });
});