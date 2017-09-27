$(document).ready(function(){

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

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
                    url: "mod_dohvacanje_kupona.php",
                    dataType: "json",
                    data: {"id":$("#program")[0].options[0].value,"exists":"DA"},
                    success: function (podaci) {
                        if(podaci !== "none"){
                            table = "";
                            table += "<table>";
                            table += "<tr>";
                            table += "<th>Naziv</th><th>Opis</th><th>Slika</th><th>Video</th><th>Vrijedi od</th><th>Vrijedi do</th><th>Bodovi</th>";
                            table += "</tr>";
                            for(var i = 0; i < podaci.length; i++) {
                                table += "<tr>";
                                table += "<td>" + podaci[i].naziv + "</td>";
                                table += "<td>" + "<a href=\"" + podaci[i].pdf + "\" target=\"_blank\">" + "Prikaži PDF" + "</td>";
                                table += "<td>" + "<a href=\"" + podaci[i].slika + "\" download>" + "Skini sliku" + "</td>";
                                if( podaci[i].video === null){
                                    table += "<td>Ne postoji</td>";
                                }
                                else{
                                    table += "<td>" + "<a href=\"" + podaci[i].video + "\" download>" + "Skini video" + "</td>";
                                }
                                table += "<td>" +  podaci[i].od.substring(8, 10) + "." + podaci[i].od.substring(5, 7) + "." + podaci[i].od.substring(0, 4) + ".</td>";
                                table += "<td>" +  podaci[i].do.substring(8, 10) + "." + podaci[i].do.substring(5, 7) + "." + podaci[i].do.substring(0, 4) + ".</td>";
                                table += "<td>" + podaci[i].potrebno + "</td>";
                                table += "</tr>";
                            }
                            table += "</table>";
                            $("#tablica").html(table);
                        }
                        else{
                            $("#tablica").html("Nema kupona definiranih za ovaj program!");
                        }
                    }
                }); 
            }
            else{
                $("#tablica").html("Nema programa koje vodite!");
                $("#program").addClass("skrij");
                $("#gumbi").html("");
            }
        } 
    });

    $("#content").on("change", "#program", function () {

        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_kupona.php",
            dataType: "json",
            data: {"id":$("#program").val(),"exists":"DA"},
            success: function (podaci) {
                if(podaci !== "none"){
                    table = "";
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Naziv</th><th>Opis</th><th>Slika</th><th>Video</th><th>Vrijedi od</th><th>Vrijedi do</th><th>Bodovi</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.length; i++) {
                        table += "<tr>";
                        table += "<td>" + podaci[i].naziv + "</td>";
                        table += "<td>" + "<a href=\"" + podaci[i].pdf + "\" target=\"_blank\">" + "Prikaži PDF" + "</td>";
                        table += "<td>" + "<a href=\"" + podaci[i].slika + "\" download>" + "Skini sliku" + "</td>";
                        if( podaci[i].video === null){
                            table += "<td>Ne postoji</td>";
                        }
                        else{
                            table += "<td>" + "<a href=\"" + podaci[i].video + "\" download>" + "Skini video" + "</td>";
                        }
                        table += "<td>" + podaci[i].od.substring(8, 10) + "." + podaci[i].od.substring(5, 7) + "." + podaci[i].od.substring(0, 4) + ".</td>";
                        table += "<td>" + podaci[i].do.substring(8, 10) + "." + podaci[i].do.substring(5, 7) + "." + podaci[i].do.substring(0, 4) + ".</td>";
                        table += "<td>" + podaci[i].potrebno + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    $("#tablica").html(table);
                }
                else{
                    $("#tablica").html("Nema kupona definiranih za ovaj program!");
                }
            }
        }); 
    });

    $("#dodaj").click(function(){
        window.location = "m_dodaj_kupon.php?id=" + $("#program").val();
    });

});