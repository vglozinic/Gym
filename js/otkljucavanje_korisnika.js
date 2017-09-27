$(document).ready(function(){

    function getUsers(poruka){

        $.ajax({
            url: "admin_dbk.php",
            method: "GET",
            dataType: "json",
            success: function(podaci) {
                if(!jQuery.isEmptyObject(podaci)){
                    table = "<h2>Otključavanje korisnika</h2>";
                    table += "<div class=\"tablica\">";
                    table += "<table>";
                    table += "<tr>";
                    table += "<th></th><th>Ime</th><th>Prezime</th><th>Korisničko ime</th><th>E-mail</th><th>Uloga</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.length; i++) {
                        table += "<tr>";
                        table += "<td>" + "<input type=\"radio\" name=\"Unlock\" value=\"" + podaci[i].id + "\">" + "</td>";
                        table += "<td>" + podaci[i].ime + "</td>";
                        table += "<td>" + podaci[i].prezime + "</td>";
                        table += "<td>" + podaci[i].username + "</td>";
                        table += "<td>" + podaci[i].email + "</td>";
                        table += "<td>" + podaci[i].naziv + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    table += "</div>";
                    table += poruka;
                    table += "<button class=\"gumb\" id=\"otkljucaj\" type=\"button\">Otključaj</button>&nbsp;&nbsp;";
                    table += "<button class=\"gumb\" id=\"otkljucaj_sve\" type=\"button\">Otključaj sve</button>";
                    $("#content").html(table);
                }
                else{
                    $("#content").html("<h2>Otključavanje korisnika</h2>Nema zapisa za ovu vrstu programa!");
                }    
            }
        });
    }

    getUsers("<br>");

    $("#content").on("click", "#otkljucaj", function (){
        if($("input:radio:checked").length > 0){
            $.ajax({
                type: "GET",
                url: "admin_zok.php",
                dataType: "json",
                data: {"id": $("input:radio:checked").val()},
                success: function (podaci) {
                    if(podaci === "success"){
                        getUsers("<p class=\"p_margin\">Korisnik je uspješno otključan!<p>");
                    }
                }
            }); 
        }
        else{
            getUsers("<p class=\"p_margin\">Nije označen niti jedan korisnik!<p>");
        }
    });

    $("#content").on("click", "#otkljucaj_sve", function (){
        
        $.ajax({
            type: "GET",
            url: "admin_zok.php",
            dataType: "json",
            data: {"id": "all"},
            success: function (podaci) {
                if(podaci === "success"){
                    getUsers("<br>");
                }
            }
        }); 
    });

});