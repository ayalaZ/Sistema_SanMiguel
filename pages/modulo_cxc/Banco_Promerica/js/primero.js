$(document).ready(function() {
    $("#descarga").on('click',function(){
        $proceso = 'descargar';
        $.ajax({
            type:'POST',
            url:'php/segundo.php',
            data:{proceso:$proceso},
            dataType:'Json',
            success:function(datax) {
                swal('Estado de la operacion', datax.msg, datax.typeinfo);
            },
            error: function () {
                swal('Error', 'Ha ocurrido un error de la base de datos', 'error');
            }
        });
    });
});