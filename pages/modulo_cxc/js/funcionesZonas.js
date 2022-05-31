$(document).ready(function() {
    $("#formZona").validate({
        rules:{
            departamento:{
                required:true,
            },
            municipio:{
                required:true,
            },
            zona:{
                required:true,
            },
            cobrador:{
                required:true,
            },
        },
        messages:{
            departamento:{
                required:"Este campo es necesario",
            },
            municipio:{
                required:"Este campo es necesario",
            },
            zona:{
                required:"Este campo es necesario",
            },
            cobrador:{
                required:"Este campo es necesario",
            },
        },
        submitHandler: function (form) {
            var form = $("#formZona");
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: 'POST',
                url: 'php/funcionesZonas.php',
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
    $("#formZona2").validate({
        rules:{
            departamento:{
                required:true,
            },
            municipio:{
                required:true,
            },
            zona:{
                required:true,
            },
            cobrador:{
                required:true,
            },
        },
        messages:{
            departamento:{
                required:"Este campo es necesario",
            },
            municipio:{
                required:"Este campo es necesario",
            },
            zona:{
                required:"Este campo es necesario",
            },
            cobrador:{
                required:"Este campo es necesario",
            },
        },
        submitHandler: function (form) {
            var form = $("#formZona2");
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: 'POST',
                url: 'php/funcionesZonas.php',
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

$(".departamento").change(function () {
    $id = $(this).val();
    $opcion = 'municipios';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesClientes.php',
        data: { id: $id, opcion: $opcion },
        dataType: 'Json',
        success: function (datax) {
            $(".municipio").empty();
            var filas = datax.filas;
            $(".municipio").append("<option value=''>Seleccionar...</option>");
            for (var i = 0; i < filas; i++) {
                var nuevafila = "<option value=" + datax.municipios[i].idMunicipio + ">" + datax.municipios[i].nombreMunicipio + "</option>";
                $(".municipio").append(nuevafila);
            }
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
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
            $(".municipio").empty();
            var filas = datax.filas;
            $(".municipio").append("<option value=''>Seleccionar...</option>");
            for (var i = 0; i < filas; i++) {
                var nuevafila = "<option value=" + datax.municipios[i].idMunicipio + ">" + datax.municipios[i].nombreMunicipio + "</option>";
                $(".municipio").append(nuevafila);
            }
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});
$("#TableZonas tbody").on('click','tr',function(){
    $codigo = $(this).attr('codigo');
    $opcion = 'zonas';
    $.ajax({
        type: 'POST',
        url: 'php/funcionesZonas.php',
        data: { id: $codigo, proceso: $opcion },
        dataType: 'Json',
        success: function (datax) {
            $(".zona").val(datax.nombreZona);
            $("#codigo").val($codigo);
            $("#editzonaModal").modal("show");
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer la informacion', 'error');
        }
    });
});
$(".close").on('click',function(){
    $("#editzonaModal").modal("hide");
});