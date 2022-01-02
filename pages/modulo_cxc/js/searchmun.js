$(buscar_datos1());
$(buscar_datos2());
$(buscar_datos3());
//$(buscar_datos3());

function buscar_datos1(consulta1){
    $.ajax({
        url: 'php/GetLocalidades.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta1: consulta1},
    })
    .done(function(respuesta1){
        $('#municipio').html(respuesta1);
    })
    .fail(function(){
        console.log("error");
    })
}

$(document).on('change', '#departamento', function(){
    var valor1 = $(this).val();
    if (valor1 != "") {
        buscar_datos1(valor1);
    }else {
        buscar_datos1();
    }
});

// DATOS PARA TRAER MUNICIPIOS

function buscar_datos2(consulta2){
    $.ajax({
        url: 'php/GetLocalidades.php',
        type: 'POST',
        dataType: 'html',
        data: {consulta2: consulta2},
    })
    .done(function(respuesta2){
        $('#colonia').html(respuesta2);
    })
    .fail(function(){
        console.log("error");
    })
}

$(document).on('change', '#municipio', function(){
    var valor2 = $(this).val();
    if (valor2 != "") {
        buscar_datos2(valor2);
    }else {
        buscar_datos2();
    }
});

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

