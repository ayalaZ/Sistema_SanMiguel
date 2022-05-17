$(".fila1").on('click',function() {
    $id = $(this).attr('id');
    window.open("ordenTrabajo.php?nOrden="+$id+"",'','height=600,width=1000,top=-150,left=500');
});
$(".fila2").on('click',function() {
    $id = $(this).attr('id');
    window.open("ordenSuspension.php?nOrden="+$id+"", '', 'height=600,width=1000,top=-300,left=500');
});
$(".fila3").on('click',function() {
    $id = $(this).attr('id');
    window . open("ordenReconexion.php?nOrden="+$id+"", '', 'height=600,width=1000,top=-300,left=200');
});
$(".fila4").on('click',function() {
    $id = $(this).attr('id');
    window.open("ordenTraslado.php?nOrden="+$id+"", '', 'height=600,width=1000,top=-300,left=200');
});