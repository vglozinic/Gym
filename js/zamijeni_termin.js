$(document).ready(function(){

    $("#zamijeni").click(function(){

        flag = false;
        error = "";

        start = parseInt($("#od").val());
        end = parseInt($("#do").val());

        if(end <= start){
            error = "Vrijeme završetka je manje od vremena početka!";
        }
        else{
            if(end > (start+2)){
                error = "Program ne može trajati više od dva sata!";
            }
            else{
                flag = true;
            }
        }

        $("#error_status").html(error);

        if(flag){
            $.ajax({
                type: "GET",
                url: "provjera_termin.php",
                dataType: "json",
                data: {"program":id_program,"termin":id_termin,"od":start,"do":end,"dan":$("#dan").val()},
                success: function (podaci) {
                    if(podaci === "ok"){
                        $.ajax({
                            type: "GET",
                            url: "mod_zapisi_termin.php",
                            dataType: "json",
                            data: {"program":id_program,"termin":id_termin,"od":start,"do":end,"dan":$("#dan").val(),"zamijeni":"DA"},
                            success: function (podaci) {
                                if(podaci === "success"){
                                    $("#content").html("<h2>Definiranje termina</h2>Uspješno ste zamijenili termin!<br><a href=\"m_termini.php\"><button class=\"gumb margin_top\" type=\"button\">Natrag</button></a>");
                                }
                            } 
                        });
                    }
                    else{
                        $("#error_status").html("Termin je u koliziji sa drugim terminom!");
                    }
                } 
            });
        }

    });

});