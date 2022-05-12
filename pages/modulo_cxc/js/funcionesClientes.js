$(document).ready(function () {
    $("#dui").mask("99999999-9");
    $("#nit").mask("9999-999999-999-9");

    $("#addcliente").validate({
        rules: {
            codigo: {
                required: true,
                number: true,
                min: 5,
            },
            nombre: {
                required: true,
            },
            nacionalidad: {
                required: true,
            },
            dui: {
                required: true,
            },
            fechaNacimiento: {
                required: true,
            },
            direccion: {
                required: true,
            },
            departamento: {
                required: true,
            },
            municipio: {
                required: true,
            },
            colonia: {
                required: true,
            },
            telefono: {
                required: true,
            },
            tipoComprobante: {
                required: true,
            },
            cobrador: {
                required: true,
            },
        },
        messages: {
            codigo: {
                required: 'Este campo es necesario',
                number: 'Solo numeros',
                min: 'Debe digitar minimo 5 digitos'
            },
            nombre: {
                required: 'Este campo es necesario',
            },
            nacionalidad: {
                required: 'Este campo es necesario',
            },
            dui: {
                required: 'Este campo es necesario',
            },
            fechaNacimiento: {
                required: 'Este campo es necesario',
            },
            direccion: {
                required: 'Este campo es necesario',
            },
            departamento: {
                required: 'Este campo es necesario',
            },
            municipio: {
                required: 'Este campo es necesario',
            },
            colonia: {
                required: 'Este campo es necesario',
            },
            telefono: {
                required: 'Este campo es necesario',
            },
            tipoComprobante: {
                required: 'Este campo es necesario',
            },
            cobrador: {
                required: 'Este campo es necesario',
            },
        },
        submitHandler: function (form) {
            var form = $("#addcliente");
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: 'POST',
                url: 'php/funcionesClientes.php',
                cache: false,
                data: formdata ? formdata : form.serialize(),
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (datax) {
                    swal('Estado de la operacion', datax.msg, datax.typeinfo);
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        setInterval('location.reload()', 1500);
                    }
                }, 
                error: function () {
                    swal('Error', 'Ha ocurrido un error al ingresar la informacion', 'error');
                }
            });
        }
    });
});
$("#departamento").change(function () {
    $id = $(this).val();
    $opcion = 'municipios';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { id: $id, opcion: $opcion },
        dataType: 'Json',
        success: function (datax) {
            $("#municipio").empty();
            var filas = datax.filas;
            $("#municipio").append("<option value=''>Seleccionar...</option>");
            for (var i = 0; i < filas; i++) {
                var nuevafila = "<option value=" + datax.municipios[i].idMunicipio + ">" + datax.municipios[i].nombreMunicipio + "</option>";
                $("#municipio").append(nuevafila);
            }
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});
$("#municipio").change(function () {
    $id = $(this).val();
    $opcion = 'colonia';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { id: $id, opcion: $opcion },
        dataType: 'Json',
        success: function (datax) {
            $("#colonia").empty();
            var filas = datax.filas;
            $("#colonia").append("<option value=''>Seleccionar...</option>");
            for (var i = 0; i < filas; i++) {
                var nuevafila = "<option value=" + datax.colonias[i].idColonia + ">" + datax.colonias[i].nombreColonia + "</option>";
                $("#colonia").append(nuevafila);
            }
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});
$("#direccion").blur(function () {
    $direccion = $(this).val();
    $("#direccionCobro").empty();
    $("#direccionCobro").append($direccion);
    $("#direccionCable").empty();
    $("#direccionCable").val($direccion);
    $("#direccionInternet").empty();
    $("#direccionInternet").val($direccion);
});
$("#mesesContratoCable").blur(function () {
    $meses = $(this).val();
    $primerMes = $("#fechaPrimerFacturaCable").val();
    $opcion = 'vencimiento1';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { meses: $meses, opcion: $opcion, primermes: $primerMes },
        dataType: 'Json',
        success: function (datax) {
            $("#vencimientoContratoCable").val(datax.fechaFinal);
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});
$("#mesesContratoInternet").blur(function () {
    $meses = $(this).val();
    $primerMes = $("#fechaPrimerFacturaInternet").val();
    $opcion = 'vencimiento1';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { meses: $meses, opcion: $opcion, primermes: $primerMes },
        dataType: 'Json',
        success: function (datax) {
            $("#vencimientoContratoInternet").val(datax.fechaFinal);
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});