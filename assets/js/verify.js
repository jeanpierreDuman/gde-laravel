$(document).ready(function() {
    function change(name) {
        var idBase = $("#" + name).html();
        var saisi = $("#saisi-" + name).val();
        var result = idBase - saisi;

        if(result < 0) {
            result = result * - 1;
        }

        $("#difference-" + name).val(result);
    }

    change("achat");
    change("vente");
    change("facture");
    change("banque");
    change("divers");

    $("#saisi-achat").change(function() {
        change("achat");
    });

    $("#saisi-vente").change(function() {
        change("vente");
    });

    $("#saisi-facture").change(function() {
        change("facture");
    });

    $("#saisi-banque").change(function() {
        change("banque");
    });

    $("#saisi-divers").change(function() {
        change("divers");
    });

    $("#form-check").submit(function() {

        if(
            $("#difference-achat").val() == 0 && $("#difference-vente").val() == 0 && $("#difference-facture").val() == 0 &&
            $("#difference-banque").val() == 0 && $("#difference-divers").val() == 0 && $("#saisi-achat").val().length > 0 && $("#saisi-vente").val().length > 0 &&
            $("#saisi-facture").val().length > 0 && $("#saisi-banque").val().length > 0 && $("#saisi-divers").val().length > 0)
        {
            $(this).submit();
        }

        event.preventDefault();
    });

});
