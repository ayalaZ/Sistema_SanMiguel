//var cuotaCable = document.getElementById("cuotaCable").value;
//var cuotaInter = document.getElementById("cuotaInter").value;

var cesc = document.getElementById("aplicarCesc").value;
document.getElementById("impuesto").value = cesc;

var radios = document.getElementsByName('aplicarCesc');

function getCesc(){
    for (var i = 0, length = radios.length; i < length; i++)
    {
     if (radios[i].checked == true)
     {
      document.getElementById("impuesto").value = radios[i].value;
      break;
     }
    }
}

// CHANGE FORM COMPORT
function nuevaOrden(){
    var creadoPor = document.getElementById("creadoPor").value;
    document.getElementById("imprimir").disabled = true;
    document.getElementById("guardar").disabled = false;
    var clearInputs = document.getElementsByClassName("input-sm");
    for (var i = 0; i < clearInputs.length; i++) {
        clearInputs[i].value = "";
        if (clearInputs[i].readOnly == true) {
            clearInputs[i].readOnly = false;
        }
        else if (clearInputs[i].disabled == true) {
            clearInputs[i].disabled = false;
        }
    }
    document.getElementById("creadoPor").value = creadoPor;
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    var time = new Date();

    var seconds = time.getSeconds();
    var minutes = time.getMinutes();
    var hour = time.getHours();
    time = hour + ':' + minutes + ':' + seconds;

    today = yyyy + '-' + mm + '-' + dd;
    document.getElementById("fechaComprobante").value = today;

    document.getElementById("totalExento").value = '0.00';
    document.getElementById("totalAfecto").value = '0.00';
    document.getElementById("total").value = '0.00';

    document.getElementById("editar").disabled = true;

    var inputs = document.getElementsByTagName('input');

    for(var i = 0; i < inputs.length; i++) {
        if(inputs[i].type.toLowerCase() == 'checkbox') {
            inputs[i].checked = false;
        }
    }
    changeAction("nueva");
}

function editarOrden(){
    document.getElementById("guardar").disabled = false;
    document.getElementById("imprimir").disabled = true;

    var editInputs = document.getElementsByClassName("input-sm");
    for (var i = 0; i < editInputs.length; i++) {
        if (editInputs[i].readOnly == true) {
            editInputs[i].readOnly = false;
        }
        else if (editInputs[i].disabled == true){
            editInputs[i].disabled = false;
        }
    }
    //document.getElementById("numeroTraslado").readOnly = true;

    changeAction("editar");
}

function guardarOrden(){
    document.getElementById('guardar2').click();
}

function changeAction(action){
    switch (action) {
        case "nueva":
            document.getElementById("ventaManual").action = "php/nuevaVentaManual.php";
            break;
        case "editar":
            document.getElementById("ventaManual").action = "php/editarVentaManual.php";
            break;
        default:

    }
}
