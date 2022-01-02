//ENABLE OR DISABLE CABLE INPUTS FOR INTERNET ORDERS
function ordenInternet(){
    token = true;
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
        token = false;
        document.getElementById("btn-internet").style.color="#039BE5";
        for (var i = 0; i < inputsCable.length; i++) {
            inputsCable[i].disabled = true;
        }
    }
    document.getElementById("tipoReconexInter").required = true;
    document.getElementById("velocidad").required = true;

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
        }
    }
    document.getElementById("tipoReconexCable").required = true;

}

// CHANGE FORM COMPORT
function nuevaOrden(){
    var creadoPor = document.getElementById("creadoPor").value;
    document.getElementById("btn-cable").disabled = false;
    document.getElementById("btn-internet").disabled = false;
    document.getElementById("imprimir").disabled = true;
    document.getElementById("guardar").disabled = false;
    document.getElementById("btn-reconexion").disabled = true;
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

    today = dd + '/' + mm + '/' + yyyy;
    document.getElementById("fechaOrden").value = today;
    //document.getElementById("hora").value = time;
    //document.getElementById("tipoOrden").value = "Técnica";
    document.getElementById("editar").disabled = true;
    //document.getElementById("nombreOrden").style.display = "none";
    changeAction("nueva");
}

function editarOrden(){
    document.getElementById("btn-cable").disabled = false;
    document.getElementById("guardar").disabled = false;
    document.getElementById("btn-internet").disabled = false;
    document.getElementById("imprimir").disabled = true;
    document.getElementById("btn-reconexion").disabled = true;

    var editInputs = document.getElementsByClassName("input-sm");
    for (var i = 0; i < editInputs.length; i++) {
        if (editInputs[i].readOnly == true) {
            editInputs[i].readOnly = false;
        }
        else if (editInputs[i].disabled == true){
            editInputs[i].disabled = false;
        }
    }
    document.getElementById("numeroReconexion").readOnly = true;
    document.getElementById("saldoCable").readOnly = true;
    document.getElementById("saldoInternet").readOnly = true;
    //document.getElementById("nodo").readOnly = true;
    document.getElementById("codigoCliente").readOnly = true;
    document.getElementById("colilla").readOnly = true;
    //document.getElementById("velocidad").disabled = true;
    document.getElementById("macModem").readOnly = true;
    document.getElementById("serieModem").readOnly = true;
    document.getElementById("fechaOrden").readOnly = true;
    document.getElementById("nombreCliente").readOnly = true;

    document.getElementById("nombreOrden").style.display = "run-in";
    var tipoServicio = document.getElementById('tipoServicio').value;
    if (tipoServicio == 'C') {
        document.getElementById('btn-internet').disabled = true;
        document.getElementById('btn-cable').style.color="#4CAF50";
        document.getElementById('tipoReconexInter').disabled=true;
        document.getElementById("velocidad").disabled = true;
        document.getElementById("fechaReconexInter").readOnly = true;
        document.getElementById("ultSuspInter").readOnly = true;
        //document.getElementById('ordenaSuspensionInter').disabled=true;
        //document.getElementById('direccionInternet').readOnly=true;
        //document.getElementById('rx').readOnly=true;
        //document.getElementById('tx').readOnly=true;
        //document.getElementById('snr').readOnly=true;
        //document.getElementById('tecnologia').readOnly=true;
    }else if (tipoServicio == 'I') {
        document.getElementById('btn-cable').disabled = true;
        document.getElementById('btn-internet').style.color="#039BE5";

        document.getElementById('tipoReconexCable').disabled=true;
        //document.getElementById('direccionCable').readOnly=true;
        document.getElementById('saldoCable').readOnly=true;
        //document.getElementById('ordenaSuspensionCable').disabled=true;
        document.getElementById('mactv').readOnly=true;
        document.getElementById("fechaReconexCable").readOnly = true;
        document.getElementById("ultSuspCable").readOnly = true;
        //document.getElementById('tecnologia').readOnly=true;
    }
    changeAction("editar");
}
function reactServicio(){
     var tipoServicio = document.getElementById('tipoServicio').value;
     var ReconexionC  = document.getElementById('fechaReconexCable').value;
     var ReconexionI  = document.getElementById('fechaReconexInter').value;
     if (tipoServicio == 'C') {
        if (ReconexionC=="") {
             document.getElementById('fechaReconexCable').required = true;
              alert("Para activar el cliente, primero llene campo de fecha de reconexión de servicio de cable tv y luego intente nuevamente reactivar");
        }else{
            
            changeAction("reactivar");
        }
     } else{
        if (ReconexionI=="") {
             document.getElementById('fechaReconexInter').required = true;
              alert("Para activar el cliente, primero llene campo de fecha de reconexión de servicio de internet y luego intente nuevamente reactivar");
        }else{
            
            changeAction("reactivar");
        }
     }
}

function changeAction(action){
    switch (action) {
        case "nueva":
            document.getElementById("ordenReconexion").action = "php/nuevaOrdenReconex.php";
            break;
        case "editar":
            document.getElementById("ordenReconexion").action = "php/editarOrdenReconex.php";
            break;
        case "reactivar":
            document.getElementById("ordenReconexion").action = "php/reactivarcliente.php";
            break;
        default:

    }
}

function imprimirOrden(){
    var nOrden = document.getElementById("numeroReconexion").value
    // Trigger the button element with a click
    window.open("php/ordenReconexionImp.php?nOrden="+nOrden, '_self');
}

function guardarOrden(){
    var token = document.getElementById("tipoServicio").value;
    if (token == "C" || token == "I") {
        document.getElementById('guardar2').click();
        document.getElementById("btn-reconexion").disabled = false;
    }else {
        alert("Por favor indique si la orden es de cable o de internet");
    }
}

function estadoCuenta(){
    var cod = document.getElementById("codigoCliente").value;
    window.open("estadoCuenta.php?codigoCliente="+cod, '_blank');
}
