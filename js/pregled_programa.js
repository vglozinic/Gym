$(document).ready(function(){

    id = "";

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};
    polje = {1:"siječnju", 2:"veljači", 3:"ožujku", 4:"travnju", 5:"svibnju", 6:"lipnju", 7:"srpnju",8:"kolovozu",9:"rujnu",10:"listopadu",11:"studenom",12:"prosincu"};

    $.ajax({
        type: "GET",
        url: "user_dohvacanje_programa.php",
        dataType: "json",
        data: {"program":"np"},
        success: function (podaci) {
            if(podaci !== "empty"){
                $("#select").html("<select id=\"program\" name=\"Program\" class=\"input\"></select>");
                for (val of podaci) {
                    if(val.popunjeno == "DA"){
                        $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + " (Popunjeno)</option>");
                    }
                    else{
                        $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                    }
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

                        if(podaci.program[0].popunjeno === "DA"){
                            $("#gumbi").html("");
                        }
                        else{
                            $("#gumbi").html("<button class=\"gumb margin_top\" id=\"prijavi\" type=\"button\">Upiši se</button>");
                        }

                        $("#opis").html(html);
                    }
                });
            }
            else{
                $("#opis").html("Upisani ste u sve trenutne programe!");
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

                if(podaci.program[0].popunjeno === "DA"){
                    $("#gumbi").html("");
                }
                else{
                    $("#gumbi").html("<button class=\"gumb margin_top\" id=\"prijavi\" type=\"button\">Upiši se</button>");
                }

                $("#opis").html(html);
            }
        }); 
    });

    $("#content").on("click", "#prijavi", function () {

        id = $("#program").val();

        $.ajax({
            type: "GET",
            url: "user_dohvacanje_opisa.php",
            dataType: "json",
            data: {"id":$("#program").val()},
            success: function (podaci) {
                $("#opis").html("Jeste li sigurni da se želite upisati u program <span class=\"podebljano\">" + podaci.program[0].naziv + "</span>?<br>Jednom prijavljeni ne možete se ispisati!");   
            }
        });

        $("#select").addClass("skrij");
        $("h2").html("Prijava u program");

        $("#gumbi").html("<button class=\"gumb margin_top\" id=\"da\" type=\"button\">Da</button>&nbsp;&nbsp;<button class=\"gumb margin_top\" id=\"ne\" type=\"button\">Ne</button");
         
    });

    $("#content").on("click", "#ne", function () {
        location.reload();  
    });

    $("#content").on("click", "#da", function () {
        $.ajax({
            type: "GET",
            url: "user_prijava.php",
            dataType: "json",
            data: {"id":id},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#opis").html("Uspješno ste se upisali u program vježbanja!");
                    $("#gumbi").html("<button class=\"gumb margin_top\" id=\"natrag\" type=\"button\">Natrag</button>");
                }
            }
        }); 
    });

    $("#content").on("click", "#natrag", function () {
        location.reload();  
    });

});