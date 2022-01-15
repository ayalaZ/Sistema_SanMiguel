$(document).ready(function() {
    $cobrador = $("#cobrador").val();
    $.ajax({
        type: 'POST',
        url: 'php/obtenerRecibo.php',
        data: { cod: $cobrador },
        dataType: 'Json',
        success: function(datax) {
            $("#ultimoRecibo").val(datax.valor);
            $("#porImp").val(0.00);
            $("#impSeg").val(0.00);
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
                $("#porImp").val("0.00");
                $("#impSeg").val("0.00");
                $("#totalAbonoImpSeg").val(datax.cuota);
                $("#meses").val(datax.meses);
                if (datax.comprobante == 1) {
                    $("input[type=checkbox]").prop("checked", false);
                    $("#creditofiscal").prop("checked", true);
                } else {
                    $("input[type=checkbox]").prop("checked", false);
                    $("#consumidorfinal").prop("checked", true);
                }
                if (datax.cambio == 'true') {
                    document.getElementById("servicio").selectedIndex = 1;
                    if (datax.estado_internet == 3) {
                        swal('Error', 'El servicio de este cliente esta suspendido', 'error');
                        $("#suspendido").prop("checked", false);
                        $("#suspendido").prop("checked", true);
                    }
                    if (datax.filas != 0) {
                        $('#cargos tbody').empty();
                        var filas = datax.filas;
                        for (var i = 0; i < filas; i++) {
                            var nuevafila = "<tr><td>" +
                                datax.tabla[i].numeroFactura + "</td><td>" +
                                datax.tabla[i].mesCargo + "</td><td>" +
                                datax.tabla[i].cuotaInternet + "</td><td>" +
                                datax.tabla[i].fechaVencimiento + "</td></tr>";
                            $("#cargos tbody").append(nuevafila);
                        }
                    } else {
                        $('#cargos tbody').empty();
                    }
                } else {
                    if (datax.estado_cable == 'T') {
                        swal('Error', 'El servicio de este cliente esta suspendido', 'error');
                        $("#suspendido").prop("checked", false);
                        $("#suspendido").prop("checked", true);
                    }
                    document.getElementById("servicio").selectedIndex = 0;
                    if (datax.filas != 0) {
                        $('#cargos tbody').empty();
                        var filas = datax.filas;
                        for (var i = 0; i < filas; i++) {
                            var nuevafila = "<tr><td>" +
                                datax.tabla[i].numeroFactura + "</td><td>" +
                                datax.tabla[i].mesCargo + "</td><td>" +
                                datax.tabla[i].cuotaCable + "</td><td>" +
                                datax.tabla[i].fechaVencimiento + "</td></tr>";
                            $("#cargos tbody").append(nuevafila);
                        }
                    } else {
                        $('#cargos tbody').empty();
                    }
                }
            },
            error: function() {
                swal('Error', 'Ha ocurrido un error al traer la informacion del cliente', 'error');
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
                if (datax.cuota == 0 || datax.cuota == null) {
                    if (datax.servicio == 'i') {
                        $select = document.getElementById("servicio");
                        $select.children[0].selected = true;
                    } else {
                        $select = document.getElementById("servicio");
                        $select.children[1].selected = true;
                    }
                    swal('Error', 'Cliente no posee el servicio seleccionado', 'error');
                } else {
                    $("#valorCuota").val(datax.cuota);
                    $("#totalPagar").val(datax.cuota);
                    $("#totalAbonoImpSeg").val(datax.cuota);
                    if (datax.servicio == 'c') {
                        if (datax.filas != 0) {
                            $('#cargos tbody').empty();
                            var filas = datax.filas;
                            for (var i = 0; i < filas; i++) {
                                var nuevafila = "<tr><td>" +
                                    datax.tabla[i].numeroFactura + "</td><td>" +
                                    datax.tabla[i].mesCargo + "</td><td>" +
                                    datax.tabla[i].cuotaCable + "</td><td>" +
                                    datax.tabla[i].fechaVencimiento + "</td></tr>";
                                $("#cargos tbody").append(nuevafila);
                            }
                        }
                    } else {
                        if (datax.filas != 0) {
                            $('#cargos tbody').empty();
                            var filas = datax.filas;
                            for (var i = 0; i < filas; i++) {
                                var nuevafila = "<tr><td>" +
                                    datax.tabla[i].numeroFactura + "</td><td>" +
                                    datax.tabla[i].mesCargo + "</td><td>" +
                                    datax.tabla[i].cuotaInternet + "</td><td>" +
                                    datax.tabla[i].fechaVencimiento + "</td></tr>";
                                $("#cargos tbody").append(nuevafila);
                            }
                        }
                    }
                }
            },
            error: function() {
                swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
            }
        });
    });

    $("#aplicarCesc").change(function() {
        if (this.checked) {
            $valor = $(this).val();
            $cuota = $("#totalPagar").val();
            $proceso = 'impuesto',
                $.ajax({
                    type: 'POST',
                    url: 'php/informacionCliente.php',
                    data: { valor: $valor, cuota: $cuota, proceso: $proceso },
                    dataType: 'Json',
                    success: function(datax) {
                        $("#porImp").val(datax.cesc);
                        $("#impSeg").val(datax.impuesto);
                        $("#totalAbonoImpSeg").val(datax.total);
                    }
                });
        }
    });
    $("#pospago").change(function() {
        if (this.checked) {
            $valor = $(this).val();
            $cuota = $("#totalPagar").val();
            $proceso = 'Sinimpuesto',
                $.ajax({
                    type: 'POST',
                    url: 'php/informacionCliente.php',
                    data: { valor: $valor, cuota: $cuota, proceso: $proceso },
                    dataType: 'Json',
                    success: function(datax) {
                        $("#porImp").val(datax.cesc);
                        $("#impSeg").val(datax.impuesto);
                        $("#totalAbonoImpSeg").val(datax.total);
                    }
                });
        }
    });
    $("#exento").change(function() {
        if (this.checked) {
            $valor = $(this).val();
            $cuota = $("#totalPagar").val();
            $proceso = 'Sinimpuesto',
                $.ajax({
                    type: 'POST',
                    url: 'php/informacionCliente.php',
                    data: { valor: $valor, cuota: $cuota, proceso: $proceso },
                    dataType: 'Json',
                    success: function(datax) {
                        $("#porImp").val(datax.cesc);
                        $("#impSeg").val(datax.impuesto);
                        $("#totalAbonoImpSeg").val(datax.total);
                    }
                });
        }
    });

    $("#xmeses").change(function() {
        $meses = $(this).val();
        $cuota = $("#valorCuota").val();
        $porcentaje = $("#porImp").val();
        $codigo = $("#codigo").val();
        $proceso = 'meses',
            $.ajax({
                type: 'POST',
                url: 'php/informacionCliente.php',
                data: { meses: $meses, cuota: $cuota, proceso: $proceso, porcentaje: $porcentaje, cod: $codigo },
                dataType: 'Json',
                success: function(datax) {
                    $("#totalPagar").val(datax.cuota);
                    $("#impSeg").val(datax.impuesto);
                    $("#totalAbonoImpSeg").val(datax.total);
                    $("#meses").val(datax.meses);
                }
            });
    });

});