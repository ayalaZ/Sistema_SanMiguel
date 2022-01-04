$(document).ready(function() {
    $("#bodega").change(function() {
        $idBodega = $(this).val();
        $.ajax({
            type: 'POST',
            data: { bodega: $idBodega },
        });
    });
});