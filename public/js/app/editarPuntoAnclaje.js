$(function() {
    $("#sistema_proteccion").on("change", function(e) {
        console.log(e.target.value);
        if (e.target.value == 0 || e.target.value == 3) {
            $("#numero_usuarios").val(1);
        } else {
            $("#numero_usuarios").val(2);
        }
    });

    $("#marca").on("change", function(e) {
        console.log(e.target.value);
        if (e.target.value == 'OTRO') {
            $("#marca_otro").css({ display: "block" });
            $("#marca_otro_input").css({ display: "block" });
        } else {
            $("#marca_otro").css({ display: "none" });
            $("#marca_otro_input").css({ display: "none" });
        }
    });
});
