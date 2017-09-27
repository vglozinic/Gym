$(document).ready(function () {
    var stranica = 1;
    var ukupno = 0;
    
    var tip = "";
    var korisnik = "";
    var order = "";
    var freq = "";

    function dnevnik() {
        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_dnevnika.php",
            data: {"stranica": stranica,"zapisi": zapis,"tip":$("#tip").val(),"korisnik":$("#korisnik").val(),"order":$("#order").val()},
            dataType: "json",
            success: function (podaci) {
                var tiphtml = "";
                var korisnikhtml = "";
                var table = "";
                var stranicenje = "";
                if (!jQuery.isEmptyObject(podaci.dnevnik)) {
                    tiphtml += "<option value=\"All\">Sve</option>";
                    for(var i = 0; i < podaci.tipovi.length; i++) {
                        tiphtml += "<option value=\"" + podaci.tipovi[i] + "\">" + podaci.tipovi[i] + "</option>";
                    }
                    korisnikhtml += "<option value=\"all\">Svi</option>";
                    for(var i = 0; i < podaci.korisnici.length; i++) {
                        korisnikhtml += "<option value=\"" + podaci.korisnici[i] + "\">" + podaci.korisnici[i] + "</option>";
                    }
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Upit</th><th>Radnja</th><th>Vrijeme</th><th>Tip</th><th>Korisnik</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.dnevnik.length; i++) {
                        table += "<tr>";
                        if( podaci.dnevnik[i].upit === ""){
                            table += "<td>Nema</td>";
                        }
                        else{
                            table += "<td>" +  podaci.dnevnik[i].upit + "</td>";
                        }
                        if( podaci.dnevnik[i].radnja === null){
                            table += "<td>Nema</td>";
                        }
                        else{
                            table += "<td>" +  podaci.dnevnik[i].radnja + "</td>";
                        }
                        table += "<td>" +  podaci.dnevnik[i].vrijeme.substring(8, 10) + "." + podaci.dnevnik[i].vrijeme.substring(5, 7) + "." + podaci.dnevnik[i].vrijeme.substring(0, 4) + ". " + podaci.dnevnik[i].vrijeme.substring(11, 16) + "</td>";
                        table += "<td>" +  podaci.dnevnik[i].tip + "</td>";
                        table += "<td>" +  podaci.dnevnik[i].username + "</td>";
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

                    $("#tip").html(tiphtml);
                    $("#korisnik").html(korisnikhtml);
                    $("#tablica_pretrazivanje").html(table);
                    $("#stranicenje_pretrazivanje").html(stranicenje);
                    
                    if (tip != "") {
                        $("#tip").val(tip);
                    }
                    if (korisnik != "") {
                        $("#korisnik").val(korisnik);
                    }
                    if (order != "") {
                        $("#order").val(order);
                    }
                }
                else {
                    $("#tablica_pretrazivanje").html("Ne postoji zapis u dnevniku.");
                    $("#stranicenje_pretrazivanje").html("");
                }
            }
        });
    }
    dnevnik();

    $("#stranicenje_pretrazivanje").on("click", ".stranica", function () {
        stranica = parseInt($(this)[0].id);
        dnevnik();
    });

    $("#stranicenje_pretrazivanje").on("click", ".lijevo", function () {
        stranica = 1;
        dnevnik();
    });

    $("#stranicenje_pretrazivanje").on("click", ".desno", function () {
        stranica = ukupno;
        dnevnik();
    });

    $("#stranicenje_pretrazivanje").on("click", ".natrag", function () {
        if ((stranica - 1) > 0){
            stranica -= 1;
            dnevnik();
        }
    });

    $("#stranicenje_pretrazivanje").on("click", ".naprijed", function () {
        if ((stranica + 1) <= ukupno){
            stranica += 1;
            dnevnik();
        }
    });

    $("#content").on("change", "#tip", function(){
        tip = $(this).val();
        stranica = 1;
        dnevnik();
    });

    $("#content").on("change", "#korisnik", function (){
        korisnik = $(this).val();
        stranica = 1;
        dnevnik();
    });

    $("#content").on("change", "#order", function () {
        order = $(this).val();
        stranica = 1;
        dnevnik();
    });

    function frekvencija() {
        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_frekvencije.php",
            dataType: "json",
            data: {"stranica": stranica,"zapisi": zapis,"freq":$("#freq").val()},
            success: function (podaci) {
                var table = "";
                var stranicenje = "";
                if (!jQuery.isEmptyObject(podaci.frekvencija)) {
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Ime</th><th>Prezime</th><th>Korisničko ime</th><th>E-mail</th><th>Uloga</th><th>Broj radnji</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.frekvencija.length; i++) {
                        table += "<tr>";
                        table += "<td>" +  podaci.frekvencija[i].ime + "</td>";
                        table += "<td>" +  podaci.frekvencija[i].prezime + "</td>";
                        table += "<td>" +  podaci.frekvencija[i].username + "</td>";
                        table += "<td>" +  podaci.frekvencija[i].email + "</td>";
                        table += "<td>" +  podaci.frekvencija[i].naziv + "</td>";
                        table += "<td>" +  podaci.frekvencija[i].broj + "</td>";
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
                    $("#tablica_frekvencija").html(table);
                    $("#stranicenje_frekvencija").html(stranicenje);
                }
                else {
                    $("#tablica_frekvencija").html("Ne postoji zapis u dnevniku.");
                    $("#stranicenje_frekvencija").html("");
                }
            }
        });
    }

    $("#content").on("change", "#freq", function (){
        stranica = 1;
        freq = $(this).val();
        frekvencija();
    });

    $("#pretrazivanje").click(function (){
        stranica = 1;
        $("#div_pretrazivanje").removeClass("skrij");
        $("#div_frekvencija").addClass("skrij");
        dnevnik();
        $("#pretrazivanje").addClass("pushed");
        $("#frekvencija").removeClass("pushed");

    });

    $("#frekvencija").click(function (){
        stranica = 1;
        $("#div_pretrazivanje").addClass("skrij");
        $("#div_frekvencija").removeClass("skrij");
        frekvencija();
        $("#frekvencija").addClass("pushed");
        $("#pretrazivanje").removeClass("pushed");
    });

    $("#stranicenje_frekvencija").on("click", ".stranica", function () {
        stranica = parseInt($(this)[0].id);
        frekvencija();
    });

    $("#stranicenje_frekvencija").on("click", ".lijevo", function () {
        stranica = 1;
        frekvencija();
    });

    $("#stranicenje_frekvencija").on("click", ".desno", function () {
        stranica = ukupno;
        frekvencija();
    });

    $("#stranicenje_frekvencija").on("click", ".natrag", function () {
        if ((stranica - 1) > 0){
            stranica -= 1;
            frekvencija();
        }
    });

    $("#stranicenje_frekvencija").on("click", ".naprijed", function () {
        if ((stranica + 1) <= ukupno){
            stranica += 1;
            frekvencija();
        }
    });
});