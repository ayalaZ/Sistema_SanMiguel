$(document).ready(function() {
    $cobrador = $("#cobrador").val();
    $.ajax({
        type: 'POST',
        url: 'php/obtenerRecibo.php',
        data: { cod: $cobrador },
        dataType: 'Json',
        success: function(datax) {
            $("#ultimoRecibo").val(datax.valor);
        },
        error: function() {
            swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
        }
    });

    $("#cobrador").change(function() {
        $cobrador = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'php/obtenerRecibo.php',
            data: { cod: $cobrador },
            dataType: 'Json',
            success: function(datax) {
                $("#ultimoRecibo").val(datax.valor);
            },
            error: function() {
                swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
            }
        });
    });

    $("#codigo").change(function() {
        $codigo = $(this).val();
        $proceso = 'codigo';
        $.ajax({
            type: 'POST',
            url: 'php/informacionCliente.php',
            data: { cod: $codigo, proceso: $proceso },
            dataType: 'Json',
            success: function(datax) {
                $("#nombreCliente").val(datax.nombre);
                $("#nrc").val(datax.nrc);
                $("#direccion").val(datax.direccion);
                $("#municipio").val(datax.municipio);
                $("#colonia").val(datax.colonia);
                $("#diaCobro").val(datax.dia);
                $("#valorCuota").val(datax.cuota);
                $("#totalPagar").val(datax.cuota);
                document.getElementById("servicio").selectedIndex = 0;
            },
            error: function() {
                swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
            }
        });
    });

    $("#servicio").change(function() {
        $servicio = $(this).val();
        $codigo = $("#codigo").val();
        $proceso = 'servicio';
        $.ajax({
            type: 'POST',
            url: 'php/informacionCliente.php',
            data: { serv: $servicio, cod: $codigo, proceso: $proceso },
            dataType: 'Json',
            success: function(datax) {
                $("#valorCuota").val(datax.cuota);
                $("#totalPagar").val(datax.cuota);
            },
            error: function() {
                swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
            }
        });
    });

    var cuotaApagar = document.getElementById("totalPagar");
    cuotaApagar.addEventListener("keydown", function(e) {
        if (e.keyCode == 13) {
            alert("mensaje de prueba");
        }
    });
});