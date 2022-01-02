$(buscar_datosSimple());

function buscar_datosSimple(consultaSimple){
    $.ajax({
        url: 'php/searchSimple.php',
        type: 'POST',
        dataType: 'html',
        data: {consultaSimple: consultaSimple},
    })
    .done(function(respuestaSimple){
        $("#datos2").html(respuestaSimple);
    })
    .fail(function(){
        console.log("error");
    })
}

$(document).on('keyup', '#caja_busqueda2', function(){
    var valor = $(this).val();
    if (valor != "") {
        buscar_datosSimple(valor);
    }else {
        buscar_datosSimple();
    }
});
