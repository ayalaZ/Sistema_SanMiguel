//$(buscar_datos());
$(buscar_datos_esp());

function buscar_datos(consulta) {
    $.ajax({
            url: 'php/search.php',
            type: 'POST',
            dataType: 'html',
            data: { consulta: consulta },
        })
        .done(function(respuesta) {
            $("#datos").html(respuesta);
        })
        .fail(function() {
            console.log("error");
        })
}

$(document).on('keyup', '#caja_busqueda', function() {
    var valor = $(this).val();
    if (valor != "") {
        buscar_datos(valor);
    } else {
        valor = "";
        buscar_datos(valor);
    }
});

function buscar_datos_esp(consulta, mun, col, cable, inter) {
    $.ajax({
            url: 'php/search.php',
            type: 'POST',
            dataType: 'html',
            data: { consulta: consulta, mun: mun, col: col, cable: cable, inter: inter },
        })
        .done(function(respuesta) {
            $("#datos").html(respuesta);
        })
        .fail(function() {
            console.log("error");
        })
}
/*var consulta = $('#caja_busqueda').val();
var mun = $('#municipio2').val();
var col = $('#colonia2').val();
var cable = $('[name=cableSearch]:checked').val();
var inter = $('[name=interSearch]:checked').val();
buscar_datos_esp(consulta, mun, col, cable, inter);*/

$('#municipio2').on('change', function() {
    var consulta = $('#caja_busqueda').val();
    var mun = $('#municipio2').val();
    var col = $('#colonia2').val();
    var cable = $('[name=cableSearch]:checked').val();
    var inter = $('[name=interSearch]:checked').val();
    buscar_datos_esp(consulta, mun, col, cable, inter);
});
$('#colonia2').on('change', function() {
    var consulta = $('#caja_busqueda').val();
    var mun = $('#municipio2').val();
    var col = $('#colonia2').val();
    var cable = $('[name=cableSearch]:checked').val();
    var inter = $('[name=interSearch]:checked').val();
    buscar_datos_esp(consulta, mun, col, cable, inter);
});
$('[name=interSearch]').on('change', function() {
    var consulta = $('#caja_busqueda').val();
    var mun = $('#municipio2').val();
    var col = $('#colonia2').val();
    var cable = $('[name=cableSearch]:checked').val();
    var inter = $('[name=interSearch]:checked').val();
    buscar_datos_esp(consulta, mun, col, cable, inter);
});
$('[name=cableSearch]').on('change', function() {
    var consulta = $('#caja_busqueda').val();
    var mun = $('#municipio2').val();
    var col = $('#colonia2').val();
    var cable = $('[name=cableSearch]:checked').val();
    var inter = $('[name=interSearch]:checked').val();
    buscar_datos_esp(consulta, mun, col, cable, inter);
});
$(document).on('keyup', '#caja_busqueda', function() {
    var consulta = $('#caja_busqueda').val();
    var mun = $('#municipio2').val();
    var col = $('#colonia2').val();
    var cable = $('[name=cableSearch]:checked').val();
    var inter = $('[name=interSearch]:checked').val();
    buscar_datos_esp(consulta, mun, col, cable, inter);
});