$(buscar_datos3());

function buscar_datos3(consulta3){
    $.ajax({
        url: 'php/GetLocalidades.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta3: consulta3},
    })
        .done(function(respuesta3){
            $('#colonia2').html(respuesta3);
        })
        .fail(function(){
            console.log("error");
        })
}

$(document).on('change', '#municipio2', function(){
    var valor3 = $(this).val();
    if (valor3 != "") {
        buscar_datos3(valor3);
    }else {
        buscar_datos3();
    }
});

