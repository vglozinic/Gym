$(document).ready(function(){

    id = "";

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};
    polje = {1:"siječnju", 2:"veljači", 3:"ožujku", 4:"travnju", 5:"svibnju", 6:"lipnju", 7:"srpnju",8:"kolovozu",9:"rujnu",10:"listopadu",11:"studenom",12:"prosincu"};

    $.ajax({
        type: "GET",
        url: "mod_dohvacanje_programa.php",
        dataType: "json",
        data: {"aktivan":"DA"},
        success: function (podaci) {
            if(podaci !== "empty"){
                $("#select").html("<select id=\"program\" name=\"Program\" class=\"input\"></select>");
                for (val of podaci) {
                    $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                }
                $.ajax({
                    type: "GET",
                    url: "mod_dohvacanje_pzm.php",
                    dataType: "json",
                    data: {"id":$("#program")[0].options[0].value},
                    success: function (podaci) {
                        html = "";
                        html += "<span class=\"podebljano\">Opis programa:</span> " + "<br>" + podaci.program[0].opis + "<br>";
                        html += "<span class=\"podebljano\">Vrsta programa:</span> " + podaci.program[0].vrsta + "<br>";
                        html += "<span class=\"podebljano\">Broj polaznika:</span> " + podaci.program[0].bp + " / " + podaci.program[0].bm + "<br>";
                        html += "Program se izvodi";
                        if(podaci.program[0].aktivan === "NE"){
                            html += "o";
                        }
                        html += " u " + polje[podaci.program[0].mjesec] + " " + podaci.program[0].godina + ". godine<br>";
                        html +=  "<span class=\"podebljano\">Termini:</span> <br>";

                        if(podaci.termini !== "empty"){
                            for(var i = 0; i < podaci.termini.length; i++) {
                                html += podaci.termini[i].dan + " - " + podaci.termini[i].od + ":00 do " + podaci.termini[i].do + ":00<br>";
                            }   
                        }
                        else{
                            html += "Nema definiranih termina za ovaj program.<br>";
                        }

                        $("#opis").html(html);
                    }
                }); 
            }
            else{
                $("#opis").html("Nema ovakvih programa koje vodite!");
                $("#select").html("");
                $("#otkazi").addClass("skrij");
            }
        } 
    });

    $("#content").on("change", "#program", function () {

        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_pzm.php",
            dataType: "json",
            data: {"id":$("#program").val()},
            success: function (podaci) {
                html = "";
                html += "<span class=\"podebljano\">Opis programa:</span> " + "<br>" + podaci.program[0].opis + "<br>";
                html += "<span class=\"podebljano\">Vrsta programa:</span> " + podaci.program[0].vrsta + "<br>";
                html += "<span class=\"podebljano\">Broj polaznika:</span> " + podaci.program[0].bp + " / " + podaci.program[0].bm + "<br>";
                html += "Program se izvodi";
                if(podaci.program[0].aktivan === "NE"){
                    html += "o";
                }
                html += " u " + polje[podaci.program[0].mjesec] + " " + podaci.program[0].godina + ". godine<br>";
                html +=  "<span class=\"podebljano\">Termini:</span> <br>";

                if(podaci.termini !== "empty"){
                    for(var i = 0; i < podaci.termini.length; i++) {
                        html += podaci.termini[i].dan + " - " + podaci.termini[i].od + ":00 do " + podaci.termini[i].do + ":00<br>";
                    }   
                }
                else{
                    html += "Nema definiranih termina za ovaj program.<br>";
                }

                $("#opis").html(html);
            }
        }); 
    });

    $("input:radio").change(function (){

        if($("input:radio:checked").val() === "DA"){
            $("#gumbi").html("<a href=\"m_dodaj_program.php\"><button class=\"gumb margin_top\" id=\"novi\" type=\"button\">Novi</button></a>&nbsp;&nbsp;<button class=\"gumb margin_top\" id=\"otkazi\" type=\"button\">Otkaži</button>");
        }
        else{
            $("#gumbi").html("<a href=\"m_dodaj_program.php\"><button class=\"gumb margin_top\" id=\"novi\" type=\"button\">Novi</button></a>");
        }

        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_programa.php",
            dataType: "json",
            data: {"aktivan":$("input:radio:checked").val()},
            success: function (podaci) {
                if(podaci !== "empty"){
                    $("#select").html("<select id=\"program\" name=\"Program\" class=\"input\"></select>");
                    string = "";
                    for (val of podaci) {    
                        string += "<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>";
                    }
                    $("#program").html(string);
                    $.ajax({
                        type: "GET",
                        url: "mod_dohvacanje_pzm.php",
                        dataType: "json",
                        data: {"id":$("#program").val()},
                        success: function (podaci) {
                            html = "";
                            html += "<span class=\"podebljano\">Opis programa:</span> " + "<br>" + podaci.program[0].opis + "<br>";
                            html += "<span class=\"podebljano\">Vrsta programa:</span> " + podaci.program[0].vrsta + "<br>";
                            html += "<span class=\"podebljano\">Broj polaznika:</span> " + podaci.program[0].bp + " / " + podaci.program[0].bm + "<br>";
                            html += "Program se izvodi";
                            if(podaci.program[0].aktivan === "NE"){
                                html += "o";
                            }
                            html += " u " + polje[podaci.program[0].mjesec] + " " + podaci.program[0].godina + ". godine<br>";
                            html +=  "<span class=\"podebljano\">Termini:</span> <br>";

                            if(podaci.termini !== "empty"){
                                for(var i = 0; i < podaci.termini.length; i++) {
                                    html += podaci.termini[i].dan + " - " + podaci.termini[i].od + ":00 do " + podaci.termini[i].do + ":00<br>";
                                }   
                            }
                            else{
                                html += "Nema definiranih termina za ovaj program.<br>";
                            }

                            $("#opis").html(html);
                        }
                    }); 
                }
                else{
                    $("#opis").html("Nema ovakvih programa koje vodite!");
                    $("#gumbi").html("<a href=\"m_dodaj_program.php\"><button class=\"gumb margin_top\" id=\"novi\" type=\"button\">Novi</button></a>");
                    $("#select").html("");
                }
            } 
        });

    });

    $("#content").on("click", "#otkazi", function () {

        id = $("#program").val();
        
        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_pzm.php",
            dataType: "json",
            data: {"id":$("#program").val()},
            success: function (podaci) {
                $("#opis").html("Jeste li sigurni da želite ukinuti izvođenje programa <span class=\"podebljano\">" + podaci.program[0].naziv + "</span>?<br>Jednom otkazan ne može se ponovno pokrenuti!");   
            }
        }); 

        $("#select").addClass("skrij");
        $("#odabir").addClass("skrij");
        $("h2").html("Ukidanje programa");

        $("#gumbi").html("<button class=\"gumb margin_top\" id=\"da\" type=\"button\">Da</button>&nbsp;&nbsp;<button class=\"gumb margin_top\" id=\"ne\" type=\"button\">Ne</button");
         
    });

    $("#content").on("click", "#ne", function () {
        location.reload();  
    });

    $("#content").on("click", "#da", function () {
        $.ajax({
            type: "GET",
            url: "mod_ukidanje_programa.php",
            dataType: "json",
            data: {"id":id},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#opis").html("Uspješno ste ukinuli izvođenje programa!");
                    $("#gumbi").html("<button class=\"gumb margin_top\" id=\"natrag\" type=\"button\">Natrag</button>");
                }
            }
        }); 
    });

    $("#content").on("click", "#natrag", function () {
        location.reload();  
    });

});