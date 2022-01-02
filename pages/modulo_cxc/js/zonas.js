// CHANGE FORM COMPORT
function nuevoCobrador(){
    //window.history.pushState({}, document.title, "/" + "satpro/pages/modulo_cxc/zonas.php");
    //window.location.reload();
    if (document.getElementById('nada')!==null) {
        document.getElementById('nada').id='municipio';
    }
    document.getElementById("codigoCobrador").disabled = true;
    document.getElementById("editar").disabled = true;
    document.getElementById("guardar").disabled = false;
    var clearInputs = document.getElementsByClassName("form-control");
    for (var i = 0; i < clearInputs.length; i++) {
        clearInputs[i].value = "";
        if (clearInputs[i].readOnly == true) {
            clearInputs[i].readOnly = false;
        }
        else if (clearInputs[i].disabled == true) {
            clearInputs[i].disabled = false;
        }
    }
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    var time = new Date();

    var seconds = time.getSeconds();
    var minutes = time.getMinutes();
    var hour = time.getHours();
    time = hour + ':' + minutes + ':' + seconds;

    today = dd + '/' + mm + '/' + yyyy;
    changeAction("nueva");
}

function editarCobrador(){
    document.getElementById("codigoCobrador").disabled = true;
    document.getElementById("nuevo").disabled = false;
    document.getElementById("guardar").disabled = false;

    var editInputs = document.getElementsByClassName("form-control");
    for (var i = 0; i < editInputs.length; i++) {
        if (editInputs[i].readOnly == true) {
            editInputs[i].readOnly = false;
        }
        else if (editInputs[i].disabled == true){
            editInputs[i].disabled = false;
        }
    }

    changeAction("editar");
}

function changeAction(action){
    switch (action) {
        case "nueva":
            document.getElementById("frmCob").action = "php/setZona.php?action=nuevo";
            break;
        case "editar":
            document.getElementById("frmCob").action = "php/setZona.php?action=editar";
            break;
        default:

    }
}
