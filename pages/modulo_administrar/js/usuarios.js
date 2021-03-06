$(document).ready(function () {
    $("#frmusuario").validate({
        rules: {
            nombre: {
                required: true,
            },
            apellido: {
                required: true,
            },
            usuario: {
                required: true,
            },
            rol: {
                required: true,
            },
            clave: {
                required: true,
                minlength: 8
            },
            clave_confirm: {
                required: true,
                minlength: 8,
                equalTo: "#clave",
            },
        },
        messages: {
            nombre: {
                required: "Este campo es obligatorio",
            },
            apellido: {
                required: "Este campo es obligatorio",
            },
            usuario: {
                required: "Este campo es obligatorio",
            },
            rol: {
                required: "Este campo es obligatorio",
            },
            clave: {
                required: "Este campo es obligatorio",
                minlength: "Minimo 8 carateres"
            },
            clave_confirm: {
                required: "Este campo es obligatorio",
                minlength: "Minimo 8 caratereces",
                equalTo: "La clave no coincide",
            },
        },
        submitHandler: function (form) {
            var form = $("#frmusuario");
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: 'POST',
                url: 'php/usuarios.php',
                cache: false,
                data: formdata ? formdata : form.serialize(),
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (datax) {
                    swal('Estado de la operacion', datax.msg, datax.typeinfo);
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        setInterval('location.reload()', 3000);
                    }

                }
            });
        }
    });
    $("#frmusuario2").validate({
        rules: {
            nombre: {
                required: true,
            },
            apellido: {
                required: true,
            },
            usuario: {
                required: true,
            },
            rol: {
                required: true,
            },
            clave2: {
                required: true,
                minlength: 8
            },
            clave2_confirm: {
                required: true,
                minlength: 8,
                equalTo: "#clave2",
            },
        },
        messages: {
            nombre: {
                required: "Este campo es obligatorio",
            },
            apellido: {
                required: "Este campo es obligatorio",
            },
            usuario: {
                required: "Este campo es obligatorio",
            },
            rol: {
                required: "Este campo es obligatorio",
            },
            clave2: {
                required: "Este campo es obligatorio",
                minlength: "Minimo 8 carateres"
            },
            clave2_confirm: {
                required: "Este campo es obligatorio",
                minlength: "Minimo 8 caratereces",
                equalTo: "La clave no coincide",
            },
        },
        submitHandler: function (form) {
            var form = $("#frmusuario2");
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: 'POST',
                url: 'php/usuarios.php',
                cache: false,
                data: formdata ? formdata : form.serialize(),
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (datax) {
                    swal('Estado de la operacion', datax.msg, datax.typeinfo);
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        setInterval('location.reload()', 3000);
                    }

                }
            });
        }
    });
    $("#frmusuario3").validate({
        submitHandler: function (form) {
            var form = $("#frmusuario3");
            var formdata = false;
            if (window.FormData) {
                formdata = new FormData(form[0]);
            }
            $.ajax({
                type: 'POST',
                url: 'php/usuarios.php',
                cache: false,
                data: formdata ? formdata : form.serialize(),
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (datax) {
                    swal('Estado de la operacion', datax.msg, datax.typeinfo);
                    if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                        setInterval('location.reload()', 3000);
                    }

                }
            });
        }
    });
});