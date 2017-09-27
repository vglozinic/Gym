$(document).ready(function(){

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

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
                    url: "dohvacanje_programa.php",
                    dataType: "json",
                    data: {"id":$("#vrsta")[0].options[0].value},
                    success: function (podaci) {
                        if(!jQuery.isEmptyObject(podaci)){
                            table = "<br>";
                            table += "<table>";
                            table += "<tr>";
                            table += "<th>Naziv</th><th>Opis</th><th>Razdoblje</th><th>Traje</th><th>Broj dolazaka</th>";
                            table += "</tr>";
                            for(var i = 0; i < podaci.length; i++) {
                                table += "<tr>";
                                table += "<td>" + podaci[i].naziv + "</td>";
                                table += "<td>" + podaci[i].opis + "</td>";
                                table += "<td>" + months[podaci[i].mjesec] + " " + podaci[i].godina + "</td>";
                                table += "<td>" + podaci[i].aktivan + "</td>";
                                table += "<td>" + podaci[i].broj_dolazaka + "</td>";
                                table += "</tr>";
                            }
                            table += "</table>";
                            $("#tablica_programi").html(table);
                        }
                        else{
                            $("#tablica_programi").html("Nema zapisa za ovu vrstu programa!");
                        }
                    }
                }); 
            }
        } 
    });

    $("#vrsta").change(function () {

        $.ajax({
            type: "GET",
            url: "dohvacanje_programa.php",
            dataType: "json",
            data: {"id":$("#vrsta").val()},
            success: function (podaci) {
                if(!jQuery.isEmptyObject(podaci)){
                    table = "<br>";
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Naziv</th><th>Opis</th><th>Razdoblje</th><th>Traje</th><th>Broj dolazaka</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.length; i++) {
                        table += "<tr>";
                        table += "<td>" + podaci[i].naziv + "</td>";
                        table += "<td>" + podaci[i].opis + "</td>";
                        table += "<td>" + months[podaci[i].mjesec] + " " + podaci[i].godina + "</td>";
                        table += "<td>" + podaci[i].aktivan + "</td>";
                        table += "<td>" + podaci[i].broj_dolazaka + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    $("#tablica_programi").html(table);
                }
                else{
                    $("#tablica_programi").html("Nema zapisa za ovu vrstu programa!");
                }
            }
        });
    });
});