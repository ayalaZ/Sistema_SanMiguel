$(document).ready(function () {
    $cobrador = $("#cobrador").val();
    $.ajax({
        type: 'POST',
        url: 'php/obtenerRecibo.php',
        data: { cod: $cobrador },
        dataType: 'Json',
        success: function (datax) {
            $("#ultimoRecibo").val(datax.valor);
            $("#porImp").val(0.00);
            $("#impSeg").val(0.00);
        },
        error: function () {
            swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
        }
    });
    $codigo = $("#codigo").val();
    if ($codigo != '') {
        $proceso = 'codigo';
        $.ajax({
            type: 'POST',
            url: 'php/informacionCliente.php',
            data: { cod: $codigo, proceso: $proceso },
            dataType: 'Json',
            success: function (datax) {
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
                $select = document.getElementById("xmeses");
                $select.children[0].selected = true;
            },
            error: function () {
                swal('Error', 'Ha ocurrido un error al traer la informacion del cliente', 'error');
            }
        });
    }

    $("#cobrador").change(function () {
        $cobrador = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'php/obtenerRecibo.php',
            data: { cod: $cobrador },
            dataType: 'Json',
            success: function (datax) {
                $("#ultimoRecibo").val(datax.valor);
                $("#fechaAbono").val(datax.fecha);
            },
            error: function () {
                swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
            }
        });
    });

    $("#codigo").change(function () {
        $codigo = $(this).val();
        $proceso = 'codigo';
        $.ajax({
            type: 'POST',
            url: 'php/informacionCliente.php',
            data: { cod: $codigo, proceso: $proceso },
            dataType: 'Json',
            success: function (datax) {
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
                $select = document.getElementById("xmeses");
                $select.children[0].selected = true;
            },
            error: function () {
                swal('Error', 'Ha ocurrido un error al traer la informacion del cliente', 'error');
            }
        });
        gestionCobro($codigo);
    });
    function gestionCobro(codigo) {
        $cod = codigo;
        $proceso = 'gestion';
        $.ajax({
            type: 'POST',
            url: 'php/informacionCliente.php',
            data: { proceso: $proceso, codigo: $cod },
            dataType: 'Json',
            success: function (datax) {
                $("#gestioncodigo").val(datax.id);
                $("#gestionnombre").val(datax.name);
                $("#gestiondireccion").val(datax.address);
                $("#idgestion").val(datax.idGestion);
                if (datax.filas != 0) {
                    $("#tablaGestion tbody").empty();
                    var filas = datax.filas;
                    for (var i = 0; i < filas; i++) {
                        switch (datax.tabla[i].gestion) {
                            case "0":
                                $gestion = "SUSPENDER";
                                break;
                            case "1":
                                $gestion = "PRORROGA DE 1 DIA";
                                break;
                            case "2":
                                $gestion = "PRORROGA DE 2 DIAS";
                                break;
                            case "3":
                                $gestion = "PRORROGA DE 3 DIAS";
                                break;
                            case "4":
                                $gestion = "PRORROGA DE 4 DIAS";
                                break;
                            case "5":
                                $gestion = "PRORROGA DE 5 DIAS";
                                break;
                            case "6":
                                $gestion = "SUSPENDIDO";
                                break;
                            case "7":
                                $gestion = "ENVIAR COBRADOR";
                                break;
                            case "8":
                                $gestion = "CLIENTE PAGO";
                                break;
                            case "9":
                                $gestion = "NO LOCALIZADO";
                                break;
                            default:
                                $gestion = "SIN ASIGNAR";
                                break;
                        }
                        var nuevafila = "<tr><td>" +
                            datax.tabla[i].fechaGestion + "</td><td>" +
                            datax.tabla[i].descripcion + "</td><td>" +
                            $gestion + "</td><td>" +
                            datax.tabla[i].fechaSuspension + "</td><td>" +
                            datax.tabla[i].creadoPor + "</td><td>" +
                            datax.tabla[i].tipoServicio + "</td></tr>";
                        $("#tablaGestion tbody").append(nuevafila);
                    }
                } else {
                    $("#tablaGestion tbody").empty();
                }
            }
        });
    }

    $("#servicio").change(function () {
        $servicio = $(this).val();
        $codigo = $("#codigo").val();
        $proceso = 'servicio';
        $.ajax({
            type: 'POST',
            url: 'php/informacionCliente.php',
            data: { serv: $servicio, cod: $codigo, proceso: $proceso },
            dataType: 'Json',
            success: function (datax) {
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
                    $("#meses").val(datax.nuevomes);
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
            error: function () {
                swal('Error', 'Ha ocurrido un error al traer el numero de recibo', 'error');
            }
        });
    });

    $("#aplicarCesc").change(function () {
        if (this.checked) {
            $valor = $(this).val();
            $cuota = $("#totalPagar").val();
            $proceso = 'impuesto',
                $.ajax({
                    type: 'POST',
                    url: 'php/informacionCliente.php',
                    data: { valor: $valor, cuota: $cuota, proceso: $proceso },
                    dataType: 'Json',
                    success: function (datax) {
                        $("#porImp").val(datax.cesc);
                        $("#impSeg").val(datax.impuesto);
                        $("#totalAbonoImpSeg").val(datax.total);
                    }
                });
        }
    });

    $("#mover").change(function () {
        if (this.checked) {
            $mover = 1;
            $proceso = 'mover';
            $codigo = $("#codigo").val();
            document.getElementById("xmeses").selectedIndex = 0;
            $.ajax({
                type: 'POST',
                url: 'php/informacionCliente.php',
                data: { mover: $mover, proceso: $proceso, codigo: $codigo },
                dataType: 'Json',
                success: function (datax) {
                    $("#meses").val(datax.meses);
                }
            });
        }
    });

    $("#pospago").change(function () {
        if (this.checked) {
            $valor = $(this).val();
            $cuota = $("#totalPagar").val();
            $proceso = 'Sinimpuesto',
                $.ajax({
                    type: 'POST',
                    url: 'php/informacionCliente.php',
                    data: { valor: $valor, cuota: $cuota, proceso: $proceso },
                    dataType: 'Json',
                    success: function (datax) {
                        $("#porImp").val(datax.cesc);
                        $("#impSeg").val(datax.impuesto);
                        $("#totalAbonoImpSeg").val(datax.total);
                    }
                });
        }
    });
    $("#exento").change(function () {
        if (this.checked) {
            $valor = $(this).val();
            $cuota = $("#totalPagar").val();
            $proceso = 'Sinimpuesto',
                $.ajax({
                    type: 'POST',
                    url: 'php/informacionCliente.php',
                    data: { valor: $valor, cuota: $cuota, proceso: $proceso },
                    dataType: 'Json',
                    success: function (datax) {
                        $("#porImp").val(datax.cesc);
                        $("#impSeg").val(datax.impuesto);
                        $("#totalAbonoImpSeg").val(datax.total);
                    }
                });
        }
    });

    $("#xmeses").change(function () {
        $meses = $(this).val();
        $cuota = $("#valorCuota").val();
        $porcentaje = $("#porImp").val();
        $codigo = $("#codigo").val();
        $servicio = $("#servicio").val();
        if ($("#mover").is(':checked')) {
            $mov = 1;
        } else {
            $mov = 0;
        }
        $proceso = 'meses',
            $.ajax({
                type: 'POST',
                url: 'php/informacionCliente.php',
                data: { meses: $meses, cuota: $cuota, proceso: $proceso, porcentaje: $porcentaje, cod: $codigo, serv: $servicio, mover: $mov },
                dataType: 'Json',
                success: function (datax) {
                    $("#totalPagar").val(datax.cuota);
                    $("#impSeg").val(datax.impuesto);
                    $("#totalAbonoImpSeg").val(datax.total);
                    $("#meses").val(datax.meses);
                }
            });
    });

    $("#estado").on("click", function () {
        $codigo = $("#codigo").val();
        if ($codigo == '' || $codigo == null) {
            swal('Error', 'No ha seleccionado un cliente', 'error');
        } else {
            window.open('estadoCuenta.php?codigoCliente=' + $codigo, '_blank');
        }
    });

    $("#frAbonos").validate({
        rules: {
            ultimoRecibo: {
                required: true,
            },
            diaCobro: {
                required: true
            },
            zona: {
                required: true,
            },
            cobrador: {
                required: true,
            },
            codigo: {
                required: true,
            },
            nombreCliente: {
                required: true,
            },
            nrc: {
                required: true,
            },
            municipio: {
                required: true,
            },
            colonia: {
                required: true,
            },
            direccion: {
                required: true,
            },
            servicio: {
                required: true,
            },
            valorCuota: {
                required: true,
            },
            totalPagar: {
                required: true,
            },
            porImp: {
                required: true,
            },
            impSeg: {
                required: true,
            },
            totalAbonoImpSeg: {
                required: true,
            },
            meses: {
                required: true,
            },
            xmeses: {
                required: true,
            },
        },
        messages: {
            ultimoRecibo: {
                required: "Este dato es necesario",
            },
            diaCobro: {
                required: "Este dato es necesario"
            },
            zona: {
                required: "Este dato es necesario",
            },
            cobrador: {
                required: "Este dato es necesario",
            },
            codigo: {
                required: "Este dato es necesario",
            },
            nombreCliente: {
                required: "Este dato es necesario",
            },
            nrc: {
                required: "Este dato es necesario",
            },
            municipio: {
                required: "Este dato es necesario",
            },
            colonia: {
                required: "Este dato es necesario",
            },
            direccion: {
                required: "Este dato es necesario",
            },
            servicio: {
                required: "Este dato es necesario",
            },
            valorCuota: {
                required: "Este dato es necesario",
            },
            totalPagar: {
                required: "Este dato es necesario",
            },
            porImp: {
                required: "Este dato es necesario",
            },
            impSeg: {
                required: "Este dato es necesario",
            },
            totalAbonoImpSeg: {
                required: "Este dato es necesario",
            },
            meses: {
                required: "Este dato es necesario",
            },
            xmeses: {
                required: "Este dato es necesario",
            },
        },
        submitHandler: function (form) {
            abono();
        }
    });
});

function abono() {
    $recibo = $("#ultimoRecibo").val();
    $codigo = $("#codigo").val();
    $nombre = $("#nombreCliente").val();
    $total = $("#totalAbonoImpSeg").val();
    $otromeses = $("#meses").val();
    const formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });
    if ($("#servicio").val() == 'c') {
        $servicio = 'Cable';
    } else {
        $servicio = 'Internet';
    }
    if ($("#anularComp").is(':checked')) {
        $mensajes = 'Esta a punto de anular este recibo';
    } else {
        $mensajes = "Esta a punto de abonar <mark style='background-color:yellow'>" + formatter.format($total) + "</mark> del cliente <mark style='background-color:yellow'>" + $codigo + " " + $nombre + "</mark> por el servicio de <mark style='background-color:yellow'>" + $servicio + "</mark> en el recibo numero <mark style='background-color:yellow'>" + $recibo + "</mark> Correspondiente al periodo de <mark style='background-color:yellow'>" + $otromeses + "</mark>";
    }
    swal({
        title: "??Seguro que deseas continuar?",
        html: $mensajes,
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "No",
        confirmButtonText: "Continuar",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then(function () {
        if ($('#suspendido').is(':checked')) {
            swal('Error', 'No puede realizar el abono por que este cliente esta suspendido', 'error');
        } else {
            var form = $("#frAbonos");
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);

            }
            $.ajax({
                type: 'POST',
                url: 'php/informacionCliente.php',
                cache: false,
                data: formdata ? formdata : form.serialize(),
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (datax) {
                    swal('Estado de la operacion', datax.msg, datax.typeinfo);
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        swal({
                            title: "COMPROBANTE DE PAGO",
                            text: "??Desea imprimir el recibo?",
                            type: "warning",
                            showCancelButton: true,
                            cancelButtonText: "No",
                            confirmButtonText: "Continuar",
                            closeOnConfirm: false,
                            closeOnCancel: true

                        }).then(function () {
                            window.open("php/comprobantePagox2.php?uaid1=" + datax.Crecibo + "&cod=" + datax.Ccodigo + "&desde=" + datax.Cdesde + "&hasta=" + datax.Chasta + "&tipoServicio=" + datax.Cservicio + "", "_blank");
                            setInterval('location.reload()', 500);
                        }).catch(function () {
                            setInterval('location.reload()', 500);
                        });
                    }

                }
            });
        }
    });
}

