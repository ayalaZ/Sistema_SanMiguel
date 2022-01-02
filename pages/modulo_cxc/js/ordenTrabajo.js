//ENABLE OR DISABLE CABLE INPUTS FOR INTERNET ORDERS
function ordenInternet(){
    document.getElementById("tipoServicio").value = "I";
    var inputsCable = document.getElementsByClassName("cable");
    if (inputsCable[0].disabled == true || inputsCable[0].readOnly == true) {
        document.getElementById("btn-internet").style.color="#333333";
        for (var i = 0; i < inputsCable.length; i++) {
            if (inputsCable[i].readOnly == true) {
                inputsCable[i].readOnly = false;
            }
            else if (inputsCable[i].disabled == true) {
                inputsCable[i].disabled = false;
            }
        }
    }
    else {
        document.getElementById("btn-internet").style.color="#039BE5";
        for (var i = 0; i < inputsCable.length; i++) {
            inputsCable[i].disabled = true;
        }
    }
    document.getElementById("tipoActividadInter").required=true;
    document.getElementById("tipoActividadCable").required=false;
    document.getElementById("velocidad").required=true;

}

//ENABLE OR DISABLE INTERNET INPUTS FOR CABLE ORDERS
function ordenCable(){
    document.getElementById("tipoServicio").value = "C";
    var inputsInternet = document.getElementsByClassName("internet");
    if (inputsInternet[0].disabled == true || inputsInternet[0].readOnly == true) {
        document.getElementById("btn-cable").style.color="#333333";
        for (var i = 0; i < inputsInternet.length; i++) {
            if (inputsInternet[i].readOnly == true) {
                inputsInternet[i].readOnly = false;
            }
            else if (inputsInternet[i].disabled == true) {
                inputsInternet[i].disabled = false;
            }
        }
    }
    else {
        document.getElementById("btn-cable").style.color="#4CAF50";
        for (var i = 0; i < inputsInternet.length; i++) {
            inputsInternet[i].disabled = true;
            inputsInternet[i].readOnly = true;
        }
    }
    document.getElementById("tipoActividadCable").required=true;
    document.getElementById("tipoActividadInter").required=false;

}

// CHANGE FORM COMPORT
function nuevaOrden(){
    document.getElementById("nuevaEditar").value = 1;
    document.getElementById("btn-cable").disabled = false;
    document.getElementById("btn-internet").disabled = false;
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
    document.getElementById("fechaOrden").value = today;
    document.getElementById("hora").value = time;
    document.getElementById("tipoOrden").value = "Técnica";
    document.getElementById("editar").disabled = true;
    document.getElementById("nombreOrden").style.display = "none";
    changeAction("nueva");
}

function editarOrden(){
    document.getElementById("nuevaEditar").value = 2;
    document.getElementById("nuevaOrdenId").disabled = true;
    document.getElementById("btn-cable").disabled = false;
    document.getElementById("guardar").disabled = false;
    document.getElementById("btn-internet").disabled = false;
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
    document.getElementById("numeroOrden").readOnly = true;
    document.getElementById("saldoCable").readOnly = true;
    document.getElementById("saldoInternet").readOnly = true;
    document.getElementById("nodo").readOnly = true;
    document.getElementById("colilla").readOnly = true;
    document.getElementById("velocidad").readOnly = true;
    document.getElementById("macModem").readOnly = true;
    document.getElementById("serieModem").readOnly = true;

    document.getElementById("nombreOrden").style.display = "run-in";
    var tipoServicio = document.getElementById('tipoServicio').value;
    if (tipoServicio == 'C') {
        //document.getElementById('btn-internet').disabled = true;
        document.getElementById('btn-cable').style.color="#4CAF50";
        document.getElementById('tipoActividadInter').disabled=true;
        document.getElementById('direccionInternet').readOnly=true;
        document.getElementById('rx').readOnly=true;
        document.getElementById('tx').readOnly=true;
        document.getElementById('snr').readOnly=true;
        document.getElementById('tecnologia').readOnly=true;
    }else if (tipoServicio == 'I') {
        //document.getElementById('btn-cable').disabled = true;
        document.getElementById('btn-internet').style.color="#039BE5";

        document.getElementById('tipoActividadCable').disabled=true;
        document.getElementById('direccionCable').readOnly=true;
        document.getElementById('saldoCable').readOnly=true;
        document.getElementById('tecnologia').readOnly=true;
    }
    changeAction("editar");
}

function imprimirOrden(){
    var nOrden = document.getElementById("numeroOrden").value
    // Trigger the button element with a click
    window.open("php/ordenTrabajoImp.php?nOrden="+nOrden, '_self');
}

function changeAction(action){
    switch (action) {
        case "nueva":
            document.getElementById("ordenTrabajo").action = "php/nuevaOrdenTrabajo.php";
            break;
        case "editar":
            document.getElementById("ordenTrabajo").action = "php/editarOrdenTrabajo.php";
            break;
        default:

    }
}

function guardarOrden(){
    var token = document.getElementById("tipoServicio").value;
    if (token == "C" || token == "I") {
        document.getElementById('guardar2').click();
    }else {
        alert("Por favor indique si la orden es de cable o de internet");
    }
}

function estadoCuenta(){
    var cod = document.getElementById("codigoCliente").value;
    window.open("estadoCuenta.php?codigoCliente="+cod, '_blank');
}

function changeActividad() {
    var actividadCable = document.getElementById("tipoActividadCable").value;
    var actividadInter = document.getElementById("tipoActividadInter").value;

    if (actividadCable == 'Instalación' || actividadInter == 'Instalación'){
        document.getElementById('vendedor').required = true;
    }else {
        document.getElementById('vendedor').required = false;
        if (actividadInter == 'No tiene señal' || actividadInter == 'Mala señal' || actividadInter == 'Cambio de contraseña' || actividadInter == 'Posible fuente quemada' || actividadInter == 'Internet lento') {
            document.getElementById("checksoporte").checked = true;
            document.getElementById("checksoporte").value = 1;
        }else{
            document.getElementById("checksoporte").checked = false;
            document.getElementById("checksoporte").value = 0;
        }
    }
}