$(document).ready(function(){

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    flag_naziv = false;
    flag_opis = false;

    $.ajax({
        type: "GET",
        url: "mod_dohvacanje_vrsta.php",
        dataType: "json",
        success: function (podaci) {
            if(podaci !== "empty"){
                for (val of podaci) {
                    $("#vrsta").append("<option value=\"" + val.id + "\">" + val.naziv + "</option>");
                }
            }
            else{
                $("#content").html("<br>Nemate mogućnost stvaranja programa. Kontaktirajte administratora za dodjelu vrsta.<br><br>");
            }
        } 
    });

    datum = new Date();
    godina = datum.getFullYear();
    mjesec = datum.getMonth() + 1;

    var mjeseci_kraj_html = "";
    var mjeseci_pocetak_html = "";
    var mjeseci_kraj = [];
    var mjeseci_pocetak = [];

    razdoblje = {};
    
    for(i = mjesec + 1; i <= 12; i++){
        mjeseci_kraj.push(i);
        mjeseci_kraj_html += "<option value=\"" + i + "\">" + months[i] + "</option>";
    }
    for(i = 1; i <= mjesec; i++){
        mjeseci_pocetak.push(i);
        mjeseci_pocetak_html += "<option value=\"" + i + "\">" + months[i] + "</option>";
    }

    razdoblje[godina.toString()] = mjeseci_kraj_html;
    razdoblje[(godina+1).toString()] = mjeseci_pocetak_html;

    $("#godina").html("<option value='" + godina + "'>" + godina + "</option><option value='" + (godina + 1) + "'>" + (godina + 1) + "</option>");
    $("#mjesec").html(razdoblje[$("#godina").val()]);

    $("#godina").change(function () {
        $("#mjesec").html(razdoblje[$("#godina").val()]);
    });

    $("#naziv").focusout(function (){
        if($("#naziv").val() === ""){
            flag_naziv = false;
            $("#naziv").addClass("krivo");
            $("#error_naziv").html("Naziv programa nije unesen!");
        }
        else{
            if($("#naziv").val().length <= 100){

                regex = /^[A-ZŠĐČĆŽ0-9][A-Z0-9ŠĐČĆŽa-zđčćšž\-+:. ]*[A-Z0-9a-zđčćšž]$/;

                if(regex.test($("#naziv").val())){
                    flag_naziv = true;
                    $("#naziv").removeClass("krivo");
                    $("#error_naziv").html("");
                }
                else{
                    flag_naziv = false;
                    $("#naziv").addClass("krivo");

                    regex_first = /[A-ZŠĐČĆŽ0-9]/;
                    regex_last = /[A-Z0-9a-zđčćšž]/;

                    error = "";
                    flag_error = true;
                    
                    if(!regex_first.test($("#naziv").val()[0])){
                        error += "Naziv mora početi velikim slovom ili brojkom";
                        flag_error = false;
                    }
                    if(!regex_last.test($("#naziv").val()[$("#naziv").val().length-1])){
                        if(flag_error == false){
                            error += " te završavati slovom ili brojkom";
                        }
                        else{
                            error += "Naziv mora završavati slovom ili brojkom";
                            flag_error = false;
                        }  
                    }
                    error += "!";
                    if(flag_error){
                        $("#error_naziv").html("Naziv smije sadržavati slova, brojke te znakove +, -, :, .!");
                    }
                    else{
                        $("#error_naziv").html(error);
                    }
                }
            }
            else{
                flag_naziv = false;
                $("#naziv").addClass("krivo");
                $("#error_naziv").html("Naziv mora biti kraći od 100 znakova!");
            }
        }
    });

    $("#opis").focusout(function (){
        if($("#opis").val() === ""){
            flag_opis = false;
            $("#opis").addClass("krivo");
            $("#error_opis").html("Opis programa nije unesen!");
        }
        else{
            if($("#opis").val().length <= 1000){

                regex = /^[A-ZŠĐČĆŽ][A-Z0-9ŠĐČĆŽa-zđčćšž,. ]*[.]$/;

                if(regex.test($("#opis").val())){
                    flag_opis = true;
                    $("#opis").removeClass("krivo");
                    $("#error_opis").html("");
                }
                else{
                    flag_opis = false;
                    $("#opis").addClass("krivo");

                    regex = /[A-ZŠĐČĆŽ]/;
                    
                    if(!regex.test($("#opis").val()[0]) || $("#opis").val()[$("#opis").val().length-1] !== "."){
                        $("#error_opis").html("Opis mora početi velikim slovom i završavati točkom!");
                    }
                    else{
                        $("#error_opis").html("Opis smije samo sadržavati slova, brojke, točku i zarez!");
                    }
                }
            }
            else{
                flag_opis = false;
                $("#opis").addClass("krivo");
                $("#error_opis").html("Opis mora biti kraći od 1000 znakova!");
            }
        }
    });

    $("#content").on("click", "#natrag", function () {
        location.reload();  
    });

    $("#content").on("click", "#pokreni", function(){

        $("#naziv").blur();
        $("#opis").blur();

        if(flag_naziv && flag_opis){

            text = $("#opis").val().replace(/\s\s+/g, " ");
            
            $.ajax({
                type: "POST",
                url: "mod_zapisi_program.php",
                dataType: "json",
                data: {"naziv":$("#naziv").val(),"opis":text,"mjesec":$("#mjesec").val(),"godina":$("#godina").val(),"broj":$("#broj").val(),"vrsta":$("#vrsta").val()},
                success: function (podaci) {
                    if(podaci !== "error"){
                        window.location = "m_dodaj_termin.php?id=" + podaci;
                    }
                    else{
                        $("#content").html("<h2>Pokretanje novog programa vježbanja</h2>Program ovog imena u navedenom mjesecu i godini već postoji.<br><button class=\"gumb margin_top\" id=\"natrag\" type=\"button\">Natrag</button>");
                    }
                } 
            });
        }
    });

});