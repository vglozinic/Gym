$(document).ready(function(){

    $.ajax({
        type: "GET",
        url: "dohvacanje_vrsta.php",
        dataType: "json",
        success: function (podaci) {
            if(podaci !== "error"){
                for (val of podaci) {
                    $("#vrsta").append("<option value=\"" + val.id_vrsta + "\">" + val.naziv + "</option>");
                }
                $.ajax({
                    type: "GET",
                    url: "admin_dohvacanje_mzv.php",
                    dataType: "json",
                    data: {"id":$("#vrsta")[0].options[0].value},
                    success: function (podaci) {
                        if(!jQuery.isEmptyObject(podaci)){
                            table = "<br>";
                            table += "<table>";
                            table += "<tr>";
                            table += "<th>Ime</th><th>Prezime</th><th>Korisničko ime</th><th>E-mail</th>";
                            table += "</tr>";
                            for(var i = 0; i < podaci.length; i++) {
                                table += "<tr>";
                                table += "<td>" + podaci[i].ime + "</td>";
                                table += "<td>" + podaci[i].prezime + "</td>";
                                table += "<td>" + podaci[i].username + "</td>";
                                table += "<td>" + podaci[i].email + "</td>";
                                table += "</tr>";
                            }
                            table += "</table>";
                            $("#tablica_moderatori").html(table);
                        }
                        else{
                            $("#tablica_moderatori").html("Nema moderatora za ovu vrstu programa!");
                        }
                    }
                }); 
            }
        } 
    });

    $("#vrsta").change(function () {

        $.ajax({
            type: "GET",
            url: "admin_dohvacanje_mzv.php",
            dataType: "json",
            data: {"id":$("#vrsta").val()},
            success: function (podaci) {
                if(!jQuery.isEmptyObject(podaci)){
                    table = "<br>";
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Ime</th><th>Prezime</th><th>Korisničko ime</th><th>E-mail</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.length; i++) {
                        table += "<tr>";
                        table += "<td>" + podaci[i].ime + "</td>";
                        table += "<td>" + podaci[i].prezime + "</td>";
                        table += "<td>" + podaci[i].username + "</td>";
                        table += "<td>" + podaci[i].email + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    $("#tablica_moderatori").html(table);
                }
                else{
                    $("#tablica_moderatori").html("Nema zapisa za ovu vrstu programa!");
                }
            }
        });
    });

});