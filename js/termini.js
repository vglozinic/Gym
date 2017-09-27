$(document).ready(function(){

    termin = "";

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    $.ajax({
        async: false,
        type: "GET",
        url: "mod_dohvacanje_programa.php",
        dataType: "json",
        data: {"aktivan":"DA"},
        success: function (podaci) {
            if(podaci !== "empty"){
                for (val of podaci) {
                     $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                }
                $.ajax({
                    type: "GET",
                    url: "mod_dohvacanje_termina.php",
                    dataType: "json",
                    data: {"id":$("#program")[0].options[0].value},
                    success: function (podaci) {
                        if(podaci !== "empty"){
                            $("#tablica").removeClass("skrij");
                            $("#error_status").html("");
                            $("#error_tablica").html("");
                            $("#gumbi").html("<button class=\"gumb margin_top\" id=\"dodaj\" type=\"button\">Dodaj</button></a>&nbsp;&nbsp<button class=\"gumb margin_top\" id=\"otkazi\" type=\"button\">Otkaži</button></a>");
                            table = "";
                            table += "<table>";
                            table += "<tr>";
                            table += "<th></th><th>Dan</th><th>Vrijeme</th>";
                            table += "</tr>";
                            for(var i = 0; i < podaci.length; i++) {
                                table += "<tr>";
                                table += "<td>" + "<input type=\"radio\" name=\"Action\" value=\"" + podaci[i].id + "\">" + "</td>";
                                table += "<td>" + podaci[i].dan + "</td>";
                                table += "<td>" + podaci[i].od + ":00 - " + podaci[i].do + ":00</td>";
                                table += "</tr>";
                            }
                            table += "</table>";
                            $("#tablica").html(table);
                        }
                        else{
                            $("#error_status").html("Nema definiranih termina za ovaj program.");
                            $("#error_tablica").html("");
                            $("#tablica").addClass("skrij");
                            $("#gumbi").html("<button class=\"gumb margin_top\" id=\"dodaj\" type=\"button\">Dodaj</button></a>");
                        }
                    }
                });
            }
            else{
                $("#error_status").html("Nema programa koje vodite!");
                $("#tablica").html("");
                $("#program").html("");
                $("#gumbi").html("");
            }
        }
    });       

    $("#content").on("change", "#program", function(){
        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_termina.php",
            dataType: "json",
            data: {"id":$("#program").val()},
            success: function (podaci) {
                if(podaci !== "empty"){
                    $("#tablica").removeClass("skrij");
                    $("#error_status").html("");
                    $("#error_tablica").html("");
                    $("#gumbi").html("<button class=\"gumb margin_top\" id=\"dodaj\" type=\"button\">Dodaj</button></a>&nbsp;&nbsp<button class=\"gumb margin_top\" id=\"otkazi\" type=\"button\">Otkaži</button></a>");
                    table = "";
                    table += "<table>";
                    table += "<tr>";
                    table += "<th></th><th>Dan</th><th>Vrijeme</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.length; i++) {
                        table += "<tr>";
                        table += "<td>" + "<input type=\"radio\" name=\"Action\" value=\"" + podaci[i].id + "\">" + "</td>";
                        table += "<td>" + podaci[i].dan + "</td>";
                        table += "<td>" + podaci[i].od + ":00 - " + podaci[i].do + ":00</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    $("#tablica").html(table);
                }
                else{
                    $("#error_status").html("Nema definiranih termina za ovaj program.");
                    $("#tablica").addClass("skrij");
                    $("#error_tablica").html("");
                    $("#gumbi").html("<button class=\"gumb margin_top\" id=\"dodaj\" type=\"button\">Dodaj</button></a>");
                }
            }
        }); 
    });

    $("#content").on("click", "#dodaj", function(){
        window.location = "m_dodaj_termin.php?id=" + $("#program").val() + "&naziv=" + $("#program option:selected").text();
    });

    $("#content").on("click", "#otkazi", function(){

        if($("input:radio:checked").length > 0){
            window.location = "m_zamijeni_termin.php?id_program=" + $("#program").val() + "&naziv=" + $("#program option:selected").text() + "&id_termin=" + $("input:radio:checked").val();
        }
        else{
            $("#error_tablica").html("Nije označen niti jedan termin!");
        }
        
    });

});