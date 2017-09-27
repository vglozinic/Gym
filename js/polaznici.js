$(document).ready(function(){

    var flag = true;
    var program = "";
    var id_program = "";
    var id_korisnik = "";

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    function getFullPrograms(){
        $.ajax({
            async: false,
            type: "GET",
            url: "mod_dohvacanje_pzp.php",
            dataType: "json",
            data: {"locked":"NE"},
            success: function (podaci) {
                if(podaci !== "empty"){
                    html = "";
                    for (val of podaci) {
                        html += "<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>";
                    }
                    $("#program").html(html);
                    if(program != ""){
                        $("#program").val(program);
                    }
                    getAll("");
                }
                else{
                    $("#error_status").html("Nema programa koji imaju polaznike!");
                    $("#div_program").html("");
                    $("#div_aktivni").html("");
                    $("#div_zabranjeni").html("");
                    $("#gumbi").html("");
                }
            }
        });
    }

    function getLockedPrograms(){
        $.ajax({
            async: false,
            type: "GET",
            url: "mod_dohvacanje_pzp.php",
            dataType: "json",
            data: {"locked":"DA"},
            success: function (podaci) {
                if(podaci !== "empty"){
                    html = "";
                    for (val of podaci) {
                        html += "<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>";
                    }
                    $("#program").html(html);
                    $("#error_zabranjeni").html("");
                    if(program != ""){
                        $("#program").val(program);
                    }
                    if ($("#program").val() == null) {
                        $("#program").val($("#program").children("option")[0].value);
                    }
                    getLocked();
                }
                else{
                    $("#error_zabranjeni").html("Nema programa sa zabranjenim koisnicima!");
                    $("#div_zabranjeni").addClass("skrij");
                    $("#div_program").addClass("skrij");
                }
            }
        });
    }

    getFullPrograms();

    function getAll(poruka){

        $("#error_zabranjeni").html("");

        if(program != ""){
            $("#program").val(program);
        }
        if ($("#program").val() == null) {
            $("#program").val($("#program").children("option")[0].value);
        }

        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_polaznika.php",
            dataType: "json",
            data: {"id":$("#program").val(),"locked":"DA"},
            success: function (podaci) {
                if(podaci === "none"){
                    $("#zabranjeni").prop("disabled", true);
                }
                else{
                    $("#zabranjeni").prop("disabled", false);
                }
            }
        }); 

        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_polaznika.php",
            dataType: "json",
            data: {"id":$("#program").val(),"locked":"NE"},
            success: function (podaci) {
                if(podaci !== "none"){
                    table = "";
                    table += "<table>";
                    table += "<tr>";
                    table += "<th></th><th>Ime</th><th>Prezime</th><th>E-mail</th><th>Spol</th><th>Datum rođenja</th><th>Broj mobitela</th><th>Bodovi</th>";
                    table += "</tr>";
                    for(var i = 0; i < podaci.length; i++) {
                        table += "<tr>";
                        table += "<td>" + "<input type=\"radio\" name=\"Action\" value=\"" + podaci[i].id + "\">" + "</td>";
                        table += "<td>" + podaci[i].ime + "</td>";
                        table += "<td>" + podaci[i].prezime + "</td>";
                        table += "<td><a href=\"mailto:" + podaci[i].email +  "\">Pošalji mail</a></td>";
                        table += "<td>";
                        if(podaci[i].spol === "M"){
                            table += "Muški";
                        }
                        else{
                            table += "Ženski";
                        }
                        table += "</td>";
                        table += "<td>" +  podaci[i].datum.substring(8, 10) + "." + podaci[i].datum.substring(5, 7) + "." + podaci[i].datum.substring(0, 4) + ".</td>";
                        table += "<td>" + podaci[i].broj + "</td>";
                        table += "<td>" + podaci[i].bodovi + "</td>";
                        table += "</tr>";
                    }
                    table += "</table>";
                    $("#tablica").html(table);
                    $("#error_tablica").html(poruka);
                }
                else{
                    $("#tablica").html("Nema dopuštenih korisnika za ovaj program!");
                }
            }
        });              
    }

    function getLocked(){
        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_polaznika.php",
            dataType: "json",
            data: {"id":$("#program").val(),"locked":"DA"},
            success: function (podaci) {
                if(podaci !== "none"){
                    $("#error_aktivni").html("");
                    $("#error_zabranjeni").html("");
                    $("#div_zabranjeni").removeClass("skrij");
                    html = "";
                    for (val of podaci) {
                        html += "<option value=\"" + val.id + "\">" + val.ime + " " + val.prezime + "</option>";
                    }
                    $("#korisnik").html(html);
                }
            }
        });            
    }

    $("#content").on("change", "#program", function(){
        $("#error_status").html("");
        program = $(this).val();
        if(flag){
            getAll();
        }
        else{
            getLocked();
        }
    });

    getAll();

    $("#aktivni").click(function(){

        $("#error_status").html("");
        getFullPrograms();
        $("#div_aktivni").removeClass("skrij");
        $("#div_zabranjeni").addClass("skrij");
        flag = true;
        $("#aktivni").addClass("pushed");
        $("#zabranjeni").removeClass("pushed");
        $("#div_program").removeClass("skrij");
        $("#areyousureaboutthat").html("");
        

    }); 

    $("#zabranjeni").click(function (){

        $("#error_status").html("");
        getLockedPrograms();
        $("#div_aktivni").addClass("skrij");
        $("#div_zabranjeni").removeClass("skrij");
        flag = false;
        $("#aktivni").removeClass("pushed");
        $("#zabranjeni").addClass("pushed");
        $("#div_program").removeClass("skrij");
        $("#areyousureaboutthat").html("");
        

    });

    $("#content").on("click", "#ispisi", function(){

        id_program = $("#program").val();

        if($("input:radio:checked").length > 0){

            aysad = "";
            aysad += "Jeste li sigurni da želite obrisati korisnika <span class=\"podebljano\">" + $("input:radio:checked").parent("td").siblings()[0].innerText + " " + $("input:radio:checked").parent("td").siblings()[1].innerText + "</span> iz ovog programa?";
            aysad += "<br>";
            aysad += "Jednom ispisan više se neće moći upisati!";
            aysad += "<br>";
            aysad += "<button class=\"gumb margin_top\" id=\"da\" type=\"button\">Da</button>&nbsp;&nbsp;";
            aysad += "<button class=\"gumb margin_top\" id=\"ne\" type=\"button\">Ne</button>";

            $("#areyousureaboutthat").html(aysad);
            $("#div_aktivni").addClass("skrij");
            $("#div_program").addClass("skrij");
            $("#error_status").html("");
            id_korisnik = $("input:radio:checked").val();

        }
        else{
            getAll("Nije označen niti jedan korisnik!");
        }
    });

    $("#content").on("click", "#ne", function(){
        $("#areyousureaboutthat").html("");
        $("#div_aktivni").removeClass("skrij");
        $("#div_program").removeClass("skrij");
        getFullPrograms();
    });

    $("#content").on("click", "#da", function(){
        $.ajax({
            type: "GET",
            url: "mod_ispisi_korisnika.php",
            dataType: "json",
            data: {"program":id_program, "korisnik":id_korisnik},
            success: function (podaci) {
                $("#error_status").html("Uspješno ste ispisali korisnika iz ovog programa!");
                $("#div_program").removeClass("skrij");
                $("#areyousureaboutthat").html("");
                $("#div_aktivni").removeClass("skrij");
                getFullPrograms();
            }
        }); 
    });

    $("#content").on("click", "#zabrani", function(){

        id_program = $("#program").val();

        if($("input:radio:checked").length > 0){

            id_korisnik = $("input:radio:checked").val();
            naziv = $("input:radio:checked").parent("td").siblings()[0].innerText + " " + $("input:radio:checked").parent("td").siblings()[1].innerText;

            $.ajax({
                type: "GET",
                url: "mod_zabrani_dozvoli.php",
                dataType: "json",
                data: {"program":id_program, "korisnik":id_korisnik,"zabrani":"DA"},
                success: function (podaci) {
                    $("#error_status").html("Uspješno ste zabranili pristup korisniku <span class=\"podebljano\">" + naziv + "</span>!");
                    getFullPrograms();
                }
            });
        }
        else{
            getAll("Nije označen niti jedan korisnik!");
        }

    });

    $("#content").on("click", "#dozvoli", function(){

        $.ajax({
            type: "GET",
            url: "mod_zabrani_dozvoli.php",
            dataType: "json",
            data: {"program":$("#program").val(),"korisnik":$("#korisnik").val(),"zabrani":"NE"},
            success: function (podaci) {
                $("#error_status").html("Uspješno ste otključali korisnika!");
                getLockedPrograms();
            }
        });

    });

});