$(document).ready(function() {

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
            $('#bodega').val(datax.bodega);
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
            }
        });
});