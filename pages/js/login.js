<<<<<<< HEAD
$(document).ready(function() {
    $("#formulario_login").validate({
        rules: {
            user: {
                required: true,
            },
            pass: {
                required: true,
            },
            sucursal: {
                required: true,
            },
        },
        messages: {
            user: {
                required: "Este campo es necesario",
            },
            pass: {
                required: "Este campo es necesario",
            },
            sucursal: {
                required: "Este campo es necesario",
            },
        },
        submitHandler: function(form) {
            ingresar();
        }
    });
});

function ingresar() {
    var form = $("#formulario_login");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    var formAction = form.attr('action');
    $.ajax({
        type: 'POST',
        url: 'controladores/ingresar.php',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function(datax) {
            alertify.notify(datax.msg, datax.typeinfo, 5, function() { console.log('dismissed'); });
            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                setInterval('location.replace("../pages/index.php")', 500);
            }

        }
    });
=======
$(document).ready(function() {
    $("#formulario_login").validate({
        rules: {
            user: {
                required: true,
            },
            pass: {
                required: true,
            },
            sucursal: {
                required: true,
            },
        },
        messages: {
            user: {
                required: "Este campo es necesario",
            },
            pass: {
                required: "Este campo es necesario",
            },
            sucursal: {
                required: "Este campo es necesario",
            },
        },
        submitHandler: function(form) {
            ingresar();
        }
    });
});

function ingresar() {
    var form = $("#formulario_login");
    var formdata = false;
    if (window.FormData) {
        formdata = new FormData(form[0]);
    }
    var formAction = form.attr('action');
    $.ajax({
        type: 'POST',
        url: 'controladores/ingresar.php',
        cache: false,
        data: formdata ? formdata : form.serialize(),
        contentType: false,
        processData: false,
        dataType: 'json',

        success: function(datax) {
            alertify.notify(datax.msg, datax.typeinfo, 5, function() { console.log('dismissed'); });
            if (datax.typeinfo == "success" || datax.typeinfo == "Success") {
                setInterval('location.replace("../pages/index.php")', 500);
            }

        }
    });
>>>>>>> 8404f3d80dcbc2494a76c11cd1ac9cae57de7f40
}