$(document).ready(function() {
    jQuery.validator.addMethod(
        "money",
        function(value, element) {
            var isValidMoney = /^\d{0,4}(\.\d{0,2})?$/.test(value);
            return this.optional(element) || isValidMoney;
        },
        "Insert "
    );

    $("#formulario-salidas").validate({
        rules: {
            salidadfecha: {
                required: true
            },
            salidadcantidad: {
                required: true
            },
            salidaddescripcion: {
                required: true
            }
        },
        messages: {
            salidadfecha: {
                required: "Es dato es requerido",
            },
            salidadcantidad: {
                required: "Este dato es requerido",
            },
            salidaddescripcion: {
                required: 'Este dato es requerido',
            },
        },
        submitHandler: function(form) {
            agregar_salida();
        }
    });
    $("#formularioEditar").validate({
        rules: {
            Editcodigo: {
                required: true,
            },
            Editnombre: {
                required: true,
            },
            Editcantidad: {
                required: true,
            },
            Editfecha: {
                required: true,
            },
            EditprecioC: {
                required: true,
                money: true,
            },
            EditprecioV: {
                required: true,
                money: true,
            },
            Edittipo: {
                required: true,
            },
            Editcategoria: {
                required: true,
            },
            Editbodega: {
                required: true,
            },
            Editunidad: {
                required: true,
            },
            Editdescripcion: {
                required: true,
            },
            Editproveedor: {
                required: true,
            },
            Editgarantia: {
                required: true,
                min: 1,
            },
        },
        messages: {
            Editcodigo: {
                required: 'Este dato es necesario',
            },
            Editnombre: {
                required: 'Este dato es necesario',
            },
            Editcantidad: {
                required: 'Este dato es necesario',
            },
            Editfecha: {
                required: 'Este dato es necesario',
            },
            EditprecioC: {
                required: 'Este dato es necesario',
                money: 'El valor debe ser tipo moneda',
            },
            EditprecioV: {
                required: 'Este dato es necesario',
                money: 'El valor debe ser tipo moneda',
            },
            Edittipo: {
                required: 'Este dato es necesario',
            },
            Editcategoria: {
                required: 'Este dato es necesario',
            },
            Editbodega: {
                required: 'Este dato es necesario',
            },
            Editunidad: {
                required: 'Este dato es necesario',
            },
            Editdescripcion: {
                required: 'Este dato es necesario',
            },
            Editproveedor: {
                required: 'Este dato es necesario',
            },
            Editgarantia: {
                required: 'Este dato es necesario',
                min: 'La cantidad tiene que ser mayor o igual a 1',
            },
        },
        submitHandler: function(form) {
            editar_articulo();
        }
    });
    $("#formularioTrasladar").validate({
        rules: {
            Tcantidad: {
                required: true,
            },
            TbodegaD: {
                required: true,
            },
        },
        messages: {
            Tcantidad: {
                required: "Este dato es necesario",
                max: "Debe ingresar un valor que este en el rango",
                min: "Debe ingresar un valor que sea mayor a 1",
            },
            TbodegaD: {
                required: "Este dato es necesario",
            },
        },
        submitHandler: function(form) {
            trasladar_articulo();
        }
    });
    $("#formularioIngresar").validate({
        rules: {
            Addcodigo: {
                required: true,
            },
            Addnombre: {
                required: true,
            },
            Addcantidad: {
                required: true,
                min: 1,
            },
            Addfecha: {
                required: true,
            },
            AddprecioC: {
                required: true,
                money: true,
            },
            AddprecioV: {
                required: true,
                money: true,
            },
            Addtipo: {
                required: true,
            },
            Addcategoria: {
                required: true,
            },
            Addbodega: {
                required: true,
            },
            Addunidad: {
                required: true,
            },
            Adddescripcion: {
                required: true,
            },
            Addproveedor: {
                required: true,
            },
            Addgarantia: {
                required: true,
                min: 1,
            },
        },
        messages: {
            Addcodigo: {
                required: 'Este dato es necesario',
            },
            Addnombre: {
                required: 'Este dato es necesario',
            },
            Addcantidad: {
                required: 'Este dato es necesario',
                min: 'La cantidad tiene que ser mayor o igual a 1',
            },
            Addfecha: {
                required: 'Este dato es necesario',
            },
            AddprecioC: {
                required: 'Este dato es necesario',
                money: 'El valor debe ser tipo moneda',
            },
            AddprecioV: {
                required: 'Este dato es necesario',
                money: 'El valor debe ser tipo moneda',
            },
            Addtipo: {
                required: 'Este dato es necesario',
            },
            Addcategoria: {
                required: 'Este dato es necesario',
            },
            Addbodega: {
                required: 'Este dato es necesario',
            },
            Addunidad: {
                required: 'Este dato es necesario',
            },
            Adddescripcion: {
                required: 'Este dato es necesario',
            },
            Addproveedor: {
                required: 'Este dato es necesario',
            },
            Addgarantia: {
                required: 'Este dato es necesario',
                min: 'La cantidad tiene que ser mayor o igual a 1',
            },
        },
        submitHandler: function(form) {
            agregar_articulo();
        }
    });
});

$('.Ver').click(function() {
    $id = $(this).attr("data");
    $proceso = "Ver";
    $.ajax({
        type: 'POST',
        url: 'controladores/inventario.php',
        data: { id: $id, proceso: $proceso },
        dataType: 'Json',
        success: function(datax) {
            $("#codigo").val(datax.codigo);
            $("#nombre").val(datax.nombre);
            $("#descripcion").val(datax.descripcion);
            $("#cantidad").val(datax.cantidad);
            $("#fecha").val(datax.fecha);
            $('#proveedor').val(datax.proveedor);
            $('#tipo').val(datax.tipo);
            $('#categoria').val(datax.categoria);
            $('#verbodega').val(datax.bodega);
        }
    });
});

$(".Salidad").click(function() {
    $id = $(this).attr("data");
    $proceso = "salidad",
        $.ajax({
            type: 'POST',
            url: 'controladores/inventario.php',
            data: { id: $id, proceso: $proceso },
            dataType: 'Json',
            success: function(datax) {
                $("#salidad-nombre").val(datax.nombre);
                $("#id").val(datax.id);
                $("#salidadcantidad").attr({
                    "max": datax.cantidad
                });
            }
        });
});

function agregar_salida() {
    var form = $("#formulario-salidas");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: 'controladores/inventario.php',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function(datax) {
            swal('Estado de la operacion', datax.msg, datax.typeinfo);
            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                setInterval('location.reload()', 3000);
            }

        }
    });
}

function agregar_articulo() {
    var form = $("#formularioIngresar");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: 'controladores/inventario.php',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function(datax) {
            swal('Estado de la operacion', datax.msg, datax.typeinfo);
            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                setInterval('location.reload()', 3000);
            }

        }
    });
}

function editar_articulo() {
    var form = $("#formularioEditar");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: 'controladores/inventario.php',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function(datax) {
            swal('Estado de la operacion', datax.msg, datax.typeinfo);
            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                setInterval('location.reload()', 3000);
            }

        }
    });
}

$(".editar").click(function() {
    $id = $(this).attr("data");
    $proceso = "vereditar",
        $.ajax({
            type: 'POST',
            url: 'controladores/inventario.php',
            data: { id: $id, proceso: $proceso },
            dataType: 'Json',
            success: function(datax) {
                $("#Editid").val(datax.id);
                $("#EditCodigo").val(datax.codigo);
                $("#Editnombre").val(datax.nombre);
                $("#Editcantidad").val(datax.cantidad);
                $("#Editfecha").val(datax.fecha);
                $("#EditprecioC").val(datax.precioc);
                $("#EditprecioV").val(datax.preciov);
                $("#Editdescripcion").val(datax.descripcion);
                $("#Editcredito").val(datax.credito);
                $("#Editgarantia").val(datax.garantia);

                if (datax.filasproveedores != 0) {
                    $("#Editproveedor").empty();
                    var filasproveedor = datax.filasproveedores;
                    for(var i = 0; i< filasproveedor; i++){
                        if (datax.idProveedor == datax.listaproveedores[i].IdProveedor) {
                            var nuevafila = "<option value="+datax.listaproveedores[i].IdProveedor+" selected>"+datax.listaproveedores[i].nombre+"</option>";                            
                        }else{
                            var nuevafila = "<option value="+datax.listaproveedores[i].IdProveedor+">"+datax.listaproveedores[i].nombre+"</option>";
                        }
                        $("#Editproveedor").append(nuevafila);
                    }
                }

                if (datax.filastipo != 0) {
                    $("#Edittipo").empty();
                    var filastipo = datax.filastipo;
                    for(var i = 0; i< filastipo; i++){
                        if (datax.idTipoProducto == datax.listatipo[i].idTipo) {
                            var nuevafila = "<option value="+datax.listatipo[i].idTipo+" selected>"+datax.listatipo[i].nombre+"</option>";                            
                        }else{
                            var nuevafila = "<option value="+datax.listatipo[i].idTipo+">"+datax.listatipo[i].nombre+"</option>";
                        }
                        $("#Edittipo").append(nuevafila);
                    }
                }

                if(datax.filascategoria != 0) {
                    $("#Editcategoria").empty();
                    var filascategoria = datax.filascategoria;
                    for(var i = 0; i< filascategoria; i++){
                        if (datax.idCategoria == datax.listacategoria[i].idCategoria) {
                            var nuevafila = "<option value="+datax.listacategoria[i].idCategoria+" selected>"+datax.listacategoria[i].nombre+"</option>";                            
                        }else{
                            var nuevafila = "<option value="+datax.listacategoria[i].idCategoria+">"+datax.listacategoria[i].nombre+"</option>";
                        }
                        $("#Editcategoria").append(nuevafila);
                    }
                }

                if(datax.filasbodega != 0) {
                    $("#Editbodega").empty();
                    var filasbodega = datax.filasbodegas;
                    for(var i = 0; i< filasbodega; i++){
                        if (datax.idBodega == datax.listabodegas[i].idBodega) {
                            var nuevafila = "<option value="+datax.listabodegas[i].idBodega+" selected>"+datax.listabodegas[i].nombre+"</option>";                            
                        }else{
                            var nuevafila = "<option value="+datax.listabodegas[i].idBodega+">"+datax.listabodegas[i].nombre+"</option>";
                        }
                        $("#Editbodega").append(nuevafila);
                    }
                }

                if(datax.filasunidad != 0) {
                    $("#Editunidad").empty();
                    var filasunidad = datax.filasunidad;
                    for(var i = 0; i< filasunidad; i++){
                        if (datax.idUnidad == datax.listaunidad[i].idUnidad) {
                            var nuevafila = "<option value="+datax.listaunidad[i].idUnidad+" selected>"+datax.listaunidad[i].nombre+"</option>";                            
                        }else{
                            var nuevafila = "<option value="+datax.listaunidad[i].idUnidad+">"+datax.listaunidad[i].nombre+"</option>";
                        }
                        $("#Editunidad").append(nuevafila);
                    }
                }
            }
        });
});
$(".eliminar").click(function() {
    $id = $(this).attr("data");
    $proceso = "Eliminar",
        $.ajax({
            type: 'POST',
            url: "controladores/inventario.php",
            data: { id: $id, proceso: $proceso },
            dataType: 'Json',
            success: function(datax) {
                swal('Estado de la operacion', datax.msg, datax.typeinfo);
                if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                    setInterval('location.reload()', 3000);
                }
            }
        });
});
$(".trasladar").click(function() {
    $id = $(this).attr("data");
    $proceso = "vertrasladar",
        $.ajax({
            type: 'POST',
            url: 'controladores/inventario.php',
            data: { id: $id, proceso: $proceso },
            dataType: 'Json',
            success: function(datax) {
                $("#Tnombre").val(datax.nombre);
                $("#TbodegaO").val(datax.bodega);
                $("#Tcantidad").attr({
                    "max": datax.cantidad
                });
                $("#idtraslado").val(datax.id);
            }
        });
});

function trasladar_articulo() {
    var form = $("#formularioTrasladar");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    $.ajax({
        type: 'POST',
        url: 'controladores/inventario.php',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function(datax) {
            swal('Estado de la operacion', datax.msg, datax.typeinfo);
            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                setInterval('location.reload()', 3000);
            }

        }
    });
}