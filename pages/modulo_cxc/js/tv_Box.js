<< << << < HEAD
$(document).ready(function() {
            $(".delete").on('click', function(e) {
                e.preventDefault();
                var id = $(this).attr('data');
                swal({
                    title: "¿Seguro que deseas continuar?",
                    text: "No podrás deshacer este paso...",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }).then(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'php/deleteTvBox.php',
                        data: { id: id },
                        dataType: 'json',
                        success: function(datax) {
                            swal('Estado de la operacion', datax.msg, datax.typeinfo);
                            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                                setInterval('location.reload()', 3000);
                            }

                        }
                    });
                });
            });
            //poner codigo en modo reutilizable
            $(".reu").on('click', function(e) {
                e.preventDefault();
                var codigo = $(this).attr('data');
                swal({
                    title: "¿Seguro que deseas continuar?",
                    text: "No podras revertir este paso",
                    type: "warning",
                    showCancelButton: true,
                    cancelButtonText: "No",
                    confirmButtonText: "Continuar",
                    closeOnConfirm: false,
                    closeOnCancel: true
                }).then(function() {
                    $.ajax({
                        type: 'POST',
                        url: 'php/codReutilizar.php',
                        data: { cod: codigo },
                        dataType: 'json',
                        success: function(datax) {
                            swal('Estado de la operacion', datax.msg, datax.typeinfo);
                            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                                setInterval('location.reload()', 3000);
                            }
                        }
                    });
                });
            }); ===
            === =
            $(document).ready(function() {
                $(".delete").on('click', function(e) {
                    e.preventDefault();
                    var id = $(this).attr('data');
                    swal({
                        title: "¿Seguro que deseas continuar?",
                        text: "No podrás deshacer este paso...",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "No",
                        confirmButtonText: "Continuar",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }).then(function() {
                        $.ajax({
                            type: 'POST',
                            url: 'php/deleteTvBox.php',
                            data: { id: id },
                            dataType: 'json',
                            success: function(datax) {
                                swal('Estado de la operacion', datax.msg, datax.typeinfo);
                                if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                                    setInterval('location.reload()', 3000);
                                }

                            }
                        });
                    });
                });
            });