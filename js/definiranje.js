$(document).ready(function(){

    flag_od = false;
    flag_do = false;
    flag_broj = false;

    function checkDate(dan, mjesec, godina){

        leap_year = false;
        kalendar = [31,28,31,30,31,30,31,31,30,31,30,31];
        if (dan > 31 || mjesec > 12 || dan == 0 || mjesec == 0 || godina == 0){
            return false;
        }

        if(godina % 4 == 0){
            if(godina % 100 == 0){
                if(godina % 400 == 0){
                    leap_year = true;
                }
            }
            else{
                leap_year = true;
            }
        }
        
        if(dan <= kalendar[mjesec-1]){
            return true;
        }
        else{
            if(mjesec == 2 && leap_year && dan == 29){
                return true;
            }
            else{
                return false;
            }
        }
    }

    function checkFull(dan, mjesec, godina, broj){

        trenutna = new Date();

        if(godina < (trenutna.getFullYear() + broj)){
            return true;
        }
        else{
            if(godina == (trenutna.getFullYear() + broj)){
                if(mjesec < trenutna.getMonth()+1){
                    return true;
                }
                else{
                    if(mjesec == trenutna.getMonth()+1){
                        if(dan < (trenutna.getDate() + broj)){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                    else{
                        return false;
                    }
                }
            }
            else{
                return false;
            }
        }
    }

    months = {1:"Siječanj", 2:"Veljača", 3:"Ožujak", 4:"Travanj", 5:"Svibanj", 6:"Lipanj", 7:"Srpanj",8:"Kolovoz",9:"Rujan",10:"Listopad",11:"Studeni",12:"Prosinac"};

    $.ajax({
        type: "GET",
        url: "mod_dohvacanje_programa.php",
        dataType: "json",
        data: {"aktivan":"DA"},
        success: function (podaci) {
            if(podaci !== "empty"){
                for (val of podaci) {
                    $("#program").append("<option value=\"" + val.id + "\">" + val.naziv + " - " + months[val.mjesec] + " " + val.godina + "</option>");
                }
                $("#program").val(id);
                $.ajax({
                    type: "GET",
                    url: "mod_dohvacanje_kupona.php",
                    dataType: "json",
                    data: {"id":id,"exists":"NE"},
                    success: function (podaci) {
                        if(podaci !== "none"){
                            $("#error_kupon").html("");
                            $("#block").removeClass("skrij");
                            html = "";
                            for (val of podaci) {
                                html += "<option value=\"" + val.id + "\">" + val.naziv + "</option>";
                            }
                            $("#kupon").html(html);
                        }
                        else{
                            $("#block").addClass("skrij");
                            $("#error_kupon").html("Svi kuponi su definirani za ovaj program!");
                        }
                    }
                }); 
            }
        } 
    });

    $("#content").on("change", "#program", function () {

        $("#error_status").html("");

        $.ajax({
            type: "GET",
            url: "mod_dohvacanje_kupona.php",
            dataType: "json",
            data: {"id":$("#program").val(),"exists":"NE"},
            success: function (podaci) {
                if(podaci !== "none"){
                    $("#error_kupon").html("");
                    $("#block").removeClass("skrij");
                    html = "";
                    for (val of podaci) {
                        html += "<option value=\"" + val.id + "\">" + val.naziv + "</option>";
                    }
                    $("#kupon").html(html);
                }
                else{
                    $("#block").addClass("skrij");
                    $("#error_kupon").html("Svi kuponi su definirani za ovaj program!");
                }
            }
        }); 
    });

    $("#od").focusout(function (){
        if($("#od").val() === ""){
            flag_od = false;
            $("#od").addClass("krivo");
            $("#error_od").html("Nije uneseno od kad vrijedi kupon!");
        }
        else{
            regex = /^[0123][0-9]\.[01][0-9]\.[0-9]{4}\.$/;

            if(regex.test($("#od").val())){
                if(checkDate(parseInt($("#od").val().substring(0,2)),parseInt($("#od").val().substring(3,5)),parseInt($("#od").val().substring(6,10)))){

                    if(!checkFull(parseInt($("#od").val().substring(0,2)),parseInt($("#od").val().substring(3,5)),parseInt($("#od").val().substring(6,10)),0)){

                        if(checkFull(parseInt($("#od").val().substring(0,2)),parseInt($("#od").val().substring(3,5)),parseInt($("#od").val().substring(6,10)),1)){
                            flag_od = true;
                            $("#od").removeClass("krivo");
                            $("#error_od").html("");
                        }
                        else{
                            flag_od = false;
                            $("#od").addClass("krivo");
                            $("#error_od").html("Datum od je veći od današnjeg slijedeće godine!");
                        }
                    }
                    else{
                        flag_od = false;
                        $("#od").addClass("krivo");
                        $("#error_od").html("Datum od je manji od današnjeg!");
                    }
                }
                else{
                    flag_od = false;
                    $("#od").addClass("krivo");
                    $("#error_od").html("Datum od nije ispravan!");
                }
            }
            else{
                flag_od = false;
                $("#od").addClass("krivo");
                $("#error_od").html("Datum od nije u ispravnom formatu! (npr. 28.04.1994.)");
            }
        }
    });

    $("#do").focusout(function (){
        if($("#do").val() === ""){
            flag_do = false;
            $("#do").addClass("krivo");
            $("#error_do").html("Nije uneseno do kad vrijedi kupon!");
        }
        else{
            regex = /^[0123][0-9]\.[01][0-9]\.[0-9]{4}\.$/;

            if(regex.test($("#do").val())){
                if(checkDate(parseInt($("#do").val().substring(0,2)),parseInt($("#do").val().substring(3,5)),parseInt($("#do").val().substring(6,10)))){

                    if(!checkFull(parseInt($("#do").val().substring(0,2)),parseInt($("#do").val().substring(3,5)),parseInt($("#do").val().substring(6,10)),0)){

                        if(checkFull(parseInt($("#do").val().substring(0,2)),parseInt($("#do").val().substring(3,5)),parseInt($("#do").val().substring(6,10)),1)){
                            flag_do = true;
                            $("#do").removeClass("krivo");
                            $("#error_do").html("");
                        }
                        else{
                            flag_do = false;
                            $("#do").addClass("krivo");
                            $("#error_do").html("Datum do je veći od današnjeg slijedeće godine!");
                        }
                    }
                    else{
                        flag_do = false;
                        $("#do").addClass("krivo");
                        $("#error_do").html("Datum do je manji od današnjeg!");
                    }
                }
                else{
                    flag_do = false;
                    $("#do").addClass("krivo");
                    $("#error_do").html("Datum do nije ispravan!");
                }
            }
            else{
                flag_do = false;
                $("#do").addClass("krivo");
                $("#error_do").html("Datum do nije u ispravnom formatu! (npr. 28.04.1994.)");
            }
        }
    });

    $("#broj").focusout(function (){
        if($("#broj").val() === ""){
            flag_broj = false;
            $("#broj").addClass("krivo");
            $("#error_broj").html("Broj bodova nije unesen!");
        }
        else{
            regex = /^[0-9]+$/;

            if(!regex.test($("#broj").val()) || parseInt($("#broj").val()) == 0){
                flag_broj = false;
                $("#broj").addClass("krivo");
                $("#error_broj").html("Broj bodova mora biti pozitivan cijeli broj!");
            }
            else{
                if(parseInt($("#broj").val()) >= 20 && parseInt($("#broj").val()) <= 20000){
                    flag_broj = true;
                    $("#broj").removeClass("krivo");
                    $("#error_broj").html("");
                }
                else{
                    flag_broj = false;
                    $("#broj").addClass("krivo");
                    $("#error_broj").html("Broj bodova mora biti od 20 do 20000!");
                }
            }
        }
    });

    $("#spremi").click(function(){

        $("#od").blur();
        $("#do").blur();
        $("#broj").blur();

        if(flag_broj && flag_do && flag_od){
            $.ajax({
                type: "GET",
                url: "mod_definiranje_kupona.php",
                dataType: "json",
                data: {"od":$("#od").val(),"do":$("#do").val(),"broj":$("#broj").val(),"program":$("#program").val(),"kupon":$("#kupon").val()},
                success: function (podaci) {
                    if(podaci === "success"){
                        $("#content").html("<h2>Definiranje kupona za program</h2>Uspješno ste definirali kupon!<br><a href=\"m_kuponi.php\"><button class=\"gumb margin_top\" type=\"button\">Natrag</button></a>");

                    }
                    else{
                        $("#error_status").html("Dogodila se pogreška kod definiranje kupona.");
                    }
                }
            });
        }
    });

});