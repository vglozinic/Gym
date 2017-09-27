$(document).ready(function () {

    var stranica = 1;
    var ukupno = 0;
    var order = "";
    var id = "";

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    function povijest() {
        $.ajax({
            type: "GET",
            url: "user_dohvacanje_povijesti.php",
            data: {"stranica": stranica,"zapisi": zapis,"order":$("#order").val()},
            dataType: "json",
            success: function (podaci) {
                var table = "";
                var stranicenje = "";
                if (!jQuery.isEmptyObject(podaci.kosarica)) {
                    table += "<table>";
                    table += "<tr>";
                    table += "<th>Kupon</th><th>Datum</th><th>Program</th><th>Kod</th><th>Potrošeno</th><th></th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.kosarica.length; i++) {
                        table += "<tr>";
                        table += "<td>" + podaci.kosarica[i].kupon + "</td>";
                        table += "<td>" + podaci.kosarica[i].datum.substring(8, 10) + "." + podaci.kosarica[i].datum.substring(5, 7) + "." + podaci.kosarica[i].datum.substring(0, 4) + ".</td>";
                        table += "<td>" + podaci.kosarica[i].program + " - " + months[podaci.kosarica[i].mjesec] + " " + podaci.kosarica[i].godina + "</td>";
                        table += "<td>" + podaci.kosarica[i].kod + "</td>";
                        table += "<td>" + podaci.kosarica[i].potrebno + "</td>";
                        table += "<td><button class=\"kosarica\" id=\"" + podaci.kosarica[i].kod + "\" type=\"button\">PRINT</button></td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    ukupno = Math.ceil(podaci.ukupno/zapis);

                    if (ukupno > 5){
                        stranicenje += "<button class=\"gumb lijevo\"><<</button><button class=\"gumb natrag\"><</button>";
                        if (stranica == 1){
                            for (i = stranica; i <= (stranica + 4); i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else if (stranica == 2){
                            for (i = stranica-1; i <= (stranica + 3); i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else if (stranica == (ukupno - 1)){
                            for (i = stranica - 3; i <= ukupno; i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else if (stranica == ukupno){
                            for (i = stranica - 4; i <= ukupno; i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        else{
                            for (i = stranica - 2; i <= (stranica + 2); i++) {
                                stranicenje += "<button class=\"gumb stranica";
                                if (i == stranica) {
                                    stranicenje += " pushed";
                                }
                                stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                            }
                        }
                        stranicenje += "<button class=\"gumb naprijed\">></button><button class=\"gumb desno\">>></button>";
                    }
                    else{
                        for (i = 1; i <= ukupno; i++) {
                            stranicenje += "<button class=\"gumb stranica";
                            if (i == stranica) {
                                stranicenje += " pushed";
                            }
                            stranicenje += "\" id=\"" + i + "\">" + i + "</button>";
                        }
                    }

                    $("#tablica").html(table);
                    $("#stranicenje").html(stranicenje);
                    $(".kosarica").parent().css("padding","0px");
                    $(".kosarica").css("margin","0px");
                    $(".kosarica").css("border-color","white");

                    if (order != "") {
                        $("#order").val(order);
                    }
                }
                else{
                   $("#content").html("<h2>Povijest kupnje</h2>Nemate kupona koje ste kupili.");
                }
            }
        });
    }

    povijest();

    $("#stranicenje").on("click", ".stranica", function () {
        stranica = parseInt($(this)[0].id);
        povijest();
    });

     $("#stranicenje").on("click", ".lijevo", function () {
        stranica = 1;
        povijest();
    });

    $("#stranicenje").on("click", ".desno", function () {
        stranica = ukupno;
        povijest();
    });

    $("#stranicenje").on("click", ".natrag", function () {
        if ((stranica - 1) > 0){
            stranica -= 1;
            povijest();
        }
    });

    $("#stranicenje").on("click", ".naprijed", function () {
        if ((stranica + 1) <= ukupno){
            stranica += 1;
            povijest();
        }
    });

    $("#content").on("change", "#order", function(){
        order = $(this).val();
        stranica = 1;
        povijest();
    });

    $("#content").on("click", ".kosarica", function(){

        id = $(this)[0].id;
        today = new Date();
    
        $.ajax({
            async: false,
            type: "GET",
            url: "user_ispis_kupona.php",
            data: {"kod":id},
            dataType: "json",
            success: function (podaci) {
                datum = today.getDate() + "." + (today.getMonth()+1) + "." + today.getFullYear() + ".";

                var doc = new jsPDF();
                doc.setProperties({title: "Kupnja kupona - " + podaci.kupon});
                doc.setFont("times");
                doc.setFontSize(12);
                doc.text(20,20,"Teretana \"FOI WebDiP\"");
                doc.text(190,21,"Datum izdavanja: " + datum,"right");
                doc.setFont("helvetica");
                doc.setFontSize(24);
                doc.text(105,40,"KUPON " + podaci.kupon.toUpperCase(), "center");
                doc.setFontSize(16);
                doc.text(105,50,podaci.program + " - " + months[podaci.mjesec] + " " + podaci.godina, "center");
                doc.setFont("times");
                doc.setFontSize(12);
                doc.text(105,60,"Ovaj kupon kupio je clan " + podaci.ime + " " + podaci.prezime + " i vrijedi jednokratno.", "center");
                doc.text(105,65,"Cijena kupona je " + podaci.potrebno + " bodova i kupljen je " + podaci.datum.substring(8, 10) + "." + podaci.datum.substring(5, 7) + "." + podaci.datum.substring(0, 4) + ".", "center");
                doc.setFontType("bold");
                doc.text(50,80,"Kod popusta:","center");
                doc.text(160,80,"Potpis clana:","center");
                doc.setFontSize(20);
                doc.setFont("helvetica");
                doc.setFontType("normal");
                doc.text(50,90,podaci.kod,"center");
                doc.setLineWidth(0.42);
                doc.line(140,90,180,90);
                doc.setFontSize(12);
                doc.setFont("times");
                doc.text(0,110,"-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------");
                doc.text(105,115,"Prerežite ovdje","center");
                doc.output("dataurlnewwindow");
            }
        });

    });
    
});