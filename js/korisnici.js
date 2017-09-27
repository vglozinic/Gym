$(document).ready(function () {

    $.ajax({
        url: "../dohvacanje_korisnika.php",
        method: "GET",
        dataType: "json",
        success: function (podaci) {
            table = "<h2>Ispis korisnika</h2>";
            table += "<div class=\"tablica\">";
            table += "<table>";
            table += "<tr>";
            table += "<th>Ime</th><th>Prezime</th><th>Korisničko ime</th><th>E-mail</th><th>Lozinka</th><th>Uloga</th>";
            table += "</tr>";
            for(var i = 0; i < podaci.length; i++) {
                table += "<tr>";
                table += "<td>" + podaci[i].ime + "</td>"; 
                table += "<td>" + podaci[i].prezime + "</td>";
                table += "<td>" + podaci[i].username + "</td>";
                table += "<td>" + podaci[i].email + "</td>";
                table += "<td>" + podaci[i].lozinka + "</td>";
                table += "<td>" + podaci[i].naziv + "</td>";
                table += "</tr>";
            }
            table += "</table>";
            table += "</div>";
            $("#content").html(table);
        }
    });



});