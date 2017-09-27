$(document).ready(function(){

    function kosarica(){
        $.ajax({
            type: "GET",
            url: "user_dohvacanje_kosarice.php",
            dataType: "json",
            success: function (podaci) {
                if(podaci !== "empty"){
                    $("#kupi").removeClass("skrij");
                    table = "";
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Kupon</th><th>Opis</th><th>Slika</th><th>Video</th><th>Cijena</th><th>Program</th><th></th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.length; i++) {
                        table += "<tr>";
                        table += "<td>" + podaci[i].kupon + "</td>";
                        table += "<td>" + "<a href=\"" + podaci[i].opis + "\" target=\"_blank\">" + "Prikaži PDF" + "</td>";
                        table += "<td>" + "<a href=\"" + podaci[i].slika + "\" download>" + "Skini sliku" + "</td>";
                        if( podaci[i].video === null){
                            table += "<td>Ne postoji</td>";
                        }
                        else{
                            table += "<td>" + "<a href=\"" + podaci[i].video + "\" download>" + "Skini video" + "</td>";
                        }
                        table += "<td>" + podaci[i].broj + "</td>";
                        table += "<td>" + podaci[i].program + "</td>";
                        table += "<td><button class=\"kosarica\" id=\"" + podaci[i].id + "\" type=\"button\">MAKNI</button></td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    $("#tablica").html(table);
                    $(".kosarica").parent().css("padding","0px");
                    $(".kosarica").css("margin","0px");
                    $(".kosarica").css("border-color","white");
                }
                else{
                    $("#tablica").html("Trenutno nema kupona u košarici.");
                    $("#kupi").addClass("skrij");
                }
            }
        });
    }

    kosarica();

    $("#content").on("click", "#kupi", function(){
        $("#areyousureaboutthat").removeClass("skrij");
        $("#gumbi").addClass("skrij");
    });

    $("#content").on("click", "#osvjezi", function(){
        kosarica();
    });

    $("#content").on("click", "#ne", function(){
        $("#areyousureaboutthat").addClass("skrij");
        $("#gumbi").removeClass("skrij");
    });

    $("#content").on("click", "#da", function(){

        $.ajax({
            type: "GET",
            url: "user_kupnja_kupona.php",
            dataType: "json",
            success: function (podaci) {
                if (podaci === "success"){
                    $("#tablica").html("Uspješno ste kupili sve kupone! Za printanje kupona kliknite <a href=\"u_povijest_kupnje.php\">ovdje</a>.");
                    $("#gumbi").html("");
                    $("#error_status").html("");
                    $("#areyousureaboutthat").html("<a href=\"u_pregled_kupona.php\"><button class=\"gumb\" type=\"button\">Kuponi</button></a>");
                }
                else{
                    $("#error_status").html("Nemate dovoljno bodova za kupnju ovih kupona! Trenutno stanje bodova je: " + podaci);
                    $("#areyousureaboutthat").addClass("skrij");
                    $("#gumbi").removeClass("skrij");
                }
            }
        });
    });

    $("#content").on("click", ".kosarica", function(){

        id = $(this)[0].id;
        
        $("#gumbi").removeClass("skrij");
        $("#areyousureaboutthat").addClass("skrij");

        $.ajax({
            type: "GET",
            url: "user_kosarica.php",
            dataType: "json",
            data: {"id":id,"radnja":"MAKNI"},
            success: function (podaci) {
                if(podaci === "success"){
                    kosarica();
                }
            }
        });

    });

});