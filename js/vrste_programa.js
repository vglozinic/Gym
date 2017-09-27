$(document).ready(function(){

    $.ajax({
        url: "admin_dohvacanje_vrsta.php",
        method: "GET",
        dataType: "json",
        success: function(podaci) {
            if(!jQuery.isEmptyObject(podaci)){
                table = "<h2>Popis vrsta programa</h2>";
                table += "<div class=\"tablica\">";
                table += "<table>";
                table += "<tr>";
                table += "<th>Naziv</th>";
                table += "</tr>";
                for(var i = 0; i < podaci.length; i++) {
                    table += "<tr><td>" + podaci[i] + "</td></tr>";
                }
                table += "</table>";
                table += "</div>";
                table += "<br>";
                table += "<a href=\"a_dodaj_vrstu.php\"><button class=\"gumb\" type=\"button\">Dodaj</button></a>&nbsp;&nbsp;";
                table += "<a href=\"a_ukloni_vrstu.php\"><button class=\"gumb\" type=\"button\">Ukloni</button></a>";
                $("#content").html(table);                    
            }
            else{
                $("#content").html("<h2>Popis vrsta programa</h2>Ne postoje vrste programa!");
            }    
        }
    });

});