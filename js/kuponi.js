$(document).ready(function(){

    $.ajax({
        type: "GET",
        url: "admin_dohvacanje_kupona.php",
        dataType: "json",
        success: function (podaci) {
            if (!jQuery.isEmptyObject(podaci)) {
                table = "<table>";
                table += "<tr>";
                table += "<th>Naziv</th><th>Opis</th><th>Slika</th><th>Video</th>";
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
                    table += "</tr>";
                }
                table += "</table>";
                $("#tablica").html(table);
            }
            else {
                $("#tablica").html("Ne postoji ni jedan kupon.");
            } 
        } 
    });

});