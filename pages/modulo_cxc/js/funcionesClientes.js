$("#departamento").change(function(){
    $id = $(this).val();
    $opcion = 'municipios';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { id: $id,opcion: $opcion},
        dataType: 'Json',
        success: function (datax) {
            $("#municipio").empty(); 
            var filas = datax.filas;
            $("#municipio").append("<option value=''>Seleccionar...</option>");
            for (var i = 0; i < filas; i++) {
                var nuevafila = "<option value="+datax.municipios[i].idMunicipio+">"+datax.municipios[i].nombreMunicipio+"</option>"; 
                $("#municipio").append(nuevafila);               
            }
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});
$("#municipio").change(function() {
    $id = $(this).val();
    $opcion = 'colonia';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { id: $id,opcion: $opcion},
        dataType: 'Json',
        success: function (datax) {
            $("#colonia").empty(); 
            var filas = datax.filas;
            $("#colonia").append("<option value=''>Seleccionar...</option>");
            for (var i = 0; i < filas; i++) {
                var nuevafila = "<option value="+datax.colonias[i].idColonia+">"+datax.colonias[i].nombreColonia+"</option>"; 
                $("#colonia").append(nuevafila);               
            }
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});
$("#direccion").blur(function() {
    $direccion = $(this).val();
    $("#direccionCobro").empty();
    $("#direccionCobro").append($direccion);
    $("#direccionCable").empty();
    $("#direccionCable").val($direccion);
    $("#direccionInternet").empty();
    $("#direccionInternet").val($direccion);
});
$("#mesesContratoCable").blur(function() {
   $meses = $(this).val();
   $primerMes = $("#fechaPrimerFacturaCable").val();
   $opcion = 'vencimiento1';
   $.ajax({
       type: 'POST',
       url: 'php/funcionesClientes.php',
       data: { meses: $meses,opcion: $opcion,primermes:$primerMes},
       dataType: 'Json',
       success: function (datax) {
        $("#vencimientoContratoCable").val(datax.fechaFinal);
       },
       error: function () {
           swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
       }
   });
});
$("#mesesContratoInternet").blur(function() {
    $meses = $(this).val();
    $primerMes = $("#fechaPrimerFacturaInternet").val();
    $opcion = 'vencimiento1';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { meses: $meses,opcion: $opcion,primermes:$primerMes},
        dataType: 'Json',
        success: function (datax) {
         $("#vencimientoContratoInternet").val(datax.fechaFinal);
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
 });