$(document).ready(function(){

    flag_aktivacija = false;
    flag_sat = false;
    flag_minuta = false;
    flag_sekunda = false;

    $.ajax({
        type: "GET",
        url: "admin_dohvacanje_postavki.php",
        dataType: "json",
        success: function (podaci) {
            if(podaci !== "error"){
                sat = parseInt(parseInt(podaci.sesija) / 3600);
                sekunda = parseInt(parseInt(podaci.sesija) % 60);
                minuta = parseInt((podaci.sesija - (sat * 3600)) / 60);

                if(sat < 10){
                    sat = "0"+sat;
                }
                if(sekunda < 10){
                    sekunda = "0"+sekunda;
                }
                if(minuta < 10){
                    minuta = "0"+minuta;
                }

                $("#sekunda").val(sekunda);
                $("#minuta").val(minuta);
                $("#sat").val(sat);

                $("#bnp").val(podaci.bnp);
                $("#stranicenje").val(podaci.stranicenje);
                $("#aktivacija").val(podaci.aktivacija);
            }
        }
    });

    $("#spremi").click(function () {

        if($("#aktivacija").val() === ""){
            flag_aktivacija = false;
            $("#error_aktivacija").html("Broj sati nije unesen!");
        }
        else{
            regex = /^[0-9]+$/;

            if(!regex.test($("#aktivacija").val()) || parseInt($("#aktivacija").val()) == 0){
                flag_aktivacija = false;
                $("#error_aktivacija").html("Broj sati mora biti pozitivan cijeli broj!");
            }
            else{
                if(parseInt($("#aktivacija").val()) <= 720){
                    flag_aktivacija = true;
                    $("#error_aktivacija").html("");
                }
                else{
                    flag_aktivacija = false;
                    $("#error_aktivacija").html("Broj sati mora biti manji ili jednak 720!");
                }
            }
        }

        if($("#sat").val() !== ""){

            regex = /^[0-9][0-9]$/;

            if(regex.test($("#sat").val())){
                flag_sat = true;
                $("#error_sat").html("");
            }
            else{
                flag_sat = false;
                $("#error_sat").html("Sati moraju biti od 00 do 59!");
            }
        }
        else{
            flag_sat = false;
            $("#error_sat").html("Sati nisu upisani!");
        }

        if($("#minuta").val() !== ""){

            regex = /^[0-5][0-9]$/;

            if(regex.test($("#minuta").val())){
                flag_minuta = true;
                $("#error_minuta").html("");
            }
            else{
                flag_minuta = false;
                $("#error_minuta").html("Minute moraju biti od 00 do 59!");
            }
        }
        else{
            flag_minuta = false;
            $("#error_minuta").html("Minute nisu upisane!");
        }

        if($("#sekunda").val() !== ""){

            regex = /^[0-5][0-9]$/;

            if(regex.test($("#sekunda").val())){
                flag_sekunda = true;
                $("#error_sekunda").html("");
            }
            else{
                flag_sekunda = false;
                $("#error_sekunda").html("Sekunde moraju biti od 00 do 59!");
            }
        }
        else{
            flag_sekunda = false;
            $("#error_sekunda").html("Sekunde nisu upisane!");
        }

        if (flag_aktivacija && flag_sekunda && flag_sat && flag_minuta) {
            sesija = (parseInt($("#minuta").val()) * 60) + (parseInt($("#sat").val()) * 3600) + parseInt($("#sekunda").val());
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "admin_zapisivanje_postavki.php",
                data: {"sesija": sesija, "stranicenje": $("#stranicenje").val(), "bnp": $("#bnp").val(), "aktivacija": $("#aktivacija").val()},
                success: function (podaci) {
                    if(podaci !== "error"){
                        $("#error_status").html("Postavke su uspješno spremljene!");
                    }
                    else{
                        $("#error_status").html("Došlo je do pogreške u spremanju!");
                    }
                }
            });
        }
        else{
            $("#error_status").html("");
        }
    });
});