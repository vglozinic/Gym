$(document).ready(function(){

    string = "<hr>VARAŽDIN, ";

    datum = new Date();

    days = ["NEDJELJA","PONEDJELJAK", "UTORAK", "SRIJEDA", "ČETVRTAK", "PETAK", "SUBOTA"]; 
    months = {1:"SIJEČANJ", 2:"VELJAČA", 3:"OŽUJAK", 4:"TRAVANJ", 5:"SVIBANJ", 6:"LIPANJ", 7:"SRPANJ",8:"KOLOVOZ",9:"RUJAN",10:"LISTOPAD",11:"STUDENI",12:"PROSINAC"};

    string += days[datum.getDay()] + ", " + datum.getDate() + ". " + months[datum.getMonth()+1] + " " + datum.getFullYear() + "." + "<hr>";
    $("#information").html(string);

});