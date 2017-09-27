$(document).ready(function(){

    programi = {};
    $("#zabranjen").css("color", "red");

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};
    polje = {1:"siječnju", 2:"veljači", 3:"ožujku", 4:"travnju", 5:"svibnju", 6:"lipnju", 7:"srpnju",8:"kolovozu",9:"rujnu",10:"listopadu",11:"studenom",12:"prosincu"};

    $.ajax({
        type: "GET",
        url: "user_dohvacanje_programa.php",
        dataType: "json",
        data: {"program":"up"},
        success: function (podaci) {
            if(podaci !== "empty"){
                $("#select").html("<select id=\"program\" name=\"Program\" class=\"input\"></select>");
                for (val of podaci) {
                    $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                    programi[val.id.toString()] = val.zabranjen;
                }
                $.ajax({
                    type: "GET",
                    url: "user_dohvacanje_opisa.php",
                    dataType: "json",
                    data: {"id":$("#program")[0].options[0].value},
                    success: function (podaci) {
                        html = "";
                        html += "<span class=\"podebljano\">Trener:</span> " + podaci.program[0].ime + " " + podaci.program[0].prezime + "<br>";
                        html += "<span class=\"podebljano\">Izvodi se:</span> " + "u " + polje[podaci.program[0].mjesec] + " " + podaci.program[0].godina + ". godine<br>";
                        html += "<span class=\"podebljano\">Opis programa:</span> " + "<br>" + podaci.program[0].opis + "<br>";
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

                        if(programi[podaci.program[0].id] === "DA"){
                            $("#zabranjen").html("Zabranjeni ste u ovom programu!");  
                        }
                        else{
                            $("#zabranjen").html("");
                        }
                    }
                });
            }
            else{
                $("#opis").html("Niste upisani ni u jedan program!");
                $("#select").html("");
                $("#gumbi").html("");
            }
        } 
    });

    $("#content").on("change", "#program", function () {

        $.ajax({
            type: "GET",
            url: "user_dohvacanje_opisa.php",
            dataType: "json",
            data: {"id":$("#program").val()},
            success: function (podaci) {
                html = "";
                html += "<span class=\"podebljano\">Trener:</span> " + podaci.program[0].ime + " " + podaci.program[0].prezime + "<br>";
                html += "<span class=\"podebljano\">Izvodi se:</span> " + "u " + polje[podaci.program[0].mjesec] + " " + podaci.program[0].godina + ". godine<br>";
                html += "<span class=\"podebljano\">Opis programa:</span> " + "<br>" + podaci.program[0].opis + "<br>";
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

                if(programi[podaci.program[0].id] === "DA"){
                    $("#zabranjen").html("Zabranjeni ste u ovom programu!");  
                }
                else{
                    $("#zabranjen").html("");
                }
            }
        }); 
    });

    $("#content").on("click", "#dolasci", function () {
        window.location = "u_evidencija.php?id=" + $("#program").val();
    });

});