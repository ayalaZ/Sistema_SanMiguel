$(buscar_datos());

function buscar_datos(consulta){
    $.ajax({
        url: 'php/ultimoRecibo.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta: consulta},
    })
    .done(function(respuesta){
        $("#ultimoRecibo").html(respuesta);
    })
    .fail(function(){
        console.log("error");
    })
}

$(document).on('change', '#cobrador', function(){
    var valor = $(this).val();
    if (valor != "") {
        buscar_datos(valor);
    }else {
        buscar_datos();
    }
});
