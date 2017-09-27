$(document).ready(function(){

    id = "";

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    $.ajax({
        type: "GET",
        url: "user_dohvacanje_programa.php",
        dataType: "json",
        data: {"program":"up"},
        success: function (podaci) {
            if(podaci !== "empty"){
                $("#select").html("<select id=\"program\" name=\"Program\" class=\"input\"></select>");
                for (val of podaci) {
                    $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                }
                $.ajax({
                    type: "GET",
                    url: "user_dohvacanje_kupona.php",
                    dataType: "json",
                    data: {"id":$("#program")[0].options[0].value},
                    success: function (podaci) {
                        if(podaci !== "empty"){
                            html = "";
                            for(var i = 0; i < podaci.length; i++) {
                                html += "<div class=\"galerija\">";
                                html += "<span class=\"podebljano\">" + podaci[i].naziv + "</span>";
                                html += "<br><a href=\"" + podaci[i].slika + "\" target=\"_blank\"><img src=\"" + podaci[i].slika + "\" width=\"200\" height=\"200\"></a>";
                                html += "<br><a href=\"" + podaci[i].opis + "\" target=\"_blank\">Opis kupona</a>";
                                if( podaci[i].video !== null){
                                    html += " | <a href=\"" + podaci[i].video + "\" download>Skini video</a>";
                                }
                                html += "<br>Cijena: " + podaci[i].broj + " bodova";
                                html += "<br><button class=\"kosarica\" id=\"" + podaci[i].id + "\" type=\"button\">Dodaj u košaricu</button>";
                                html += "</div>";
                            }
                            $("#galerija").html(html);
                        }
                        else{
                            $("#galerija").html("Nema dostupnih kupona u ovom programu ili su svi u košarici.");
                        }  
                    }
                });
            }
            else{
                $("#content").html("<h2>Kuponi dostupni za kupnju</h2>Niste upisani ni u jedan program!");
            }
        } 
    });

    function galerija(){
        $.ajax({
            type: "GET",
            url: "user_dohvacanje_kupona.php",
            dataType: "json",
            data: {"id":$("#program").val()},
            success: function (podaci) {
                if(podaci !== "empty"){
                    html = "";
                    for(var i = 0; i < podaci.length; i++) {
                        html += "<div class=\"galerija\">";
                        html += "<span class=\"podebljano\">" + podaci[i].naziv + "</span>";
                        html += "<br><a href=\"" + podaci[i].slika + "\" target=\"_blank\"><img src=\"" + podaci[i].slika + "\" width=\"200\" height=\"200\"></a>";
                        html += "<br><a href=\"" + podaci[i].opis + "\" target=\"_blank\">Opis kupona</a>";
                        if( podaci[i].video !== null){
                            html += " | <a href=\"" + podaci[i].video + "\" download>Skini video</a>";
                        }
                        html += "<br>Cijena: " + podaci[i].broj + " bodova";
                        html += "<br><button class=\"kosarica\" id=\"" + podaci[i].id + "\" type=\"button\">Dodaj u košaricu</button>";
                        html += "</div>";
                    }
                    $("#galerija").html(html);
                }
                else{
                    $("#galerija").html("Nema dostupnih kupona u ovom programu ili su svi u košarici.");
                }    
            }
        });
    }

    $("#content").on("change", "#program", function () {
        galerija();
        $("#error_status").html("");
    });

    $("#content").on("click", ".kosarica", function () {

        id = $(this)[0].id;

        $.ajax({
            type: "GET",
            url: "user_kosarica.php",
            dataType: "json",
            data: {"id":id,"radnja":"DODAJ"},
            success: function (podaci) {
                if(podaci === "success"){
                    $("#error_status").html("Kupon je uspješno dodan u košaricu!");
                    galerija();
                }
                else{
                    $("#error_status").html("Dogodila se pogreška prilikom dodavanja u košaricu.");
                }    
            }
        });
         
    });

});