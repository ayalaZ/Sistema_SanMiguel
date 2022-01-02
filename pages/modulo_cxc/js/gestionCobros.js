//ENABLE OR DISABLE CABLE INPUTS FOR INTERNET ORDERS
function ordenInternet(){
    token = true;
    document.getElementById("tipoServicio").value = "I";
    var inputsCable = document.getElementsByClassName("cable");
    if (inputsCable[0].disabled == true || inputsCable[0].readOnly == true) {
        //document.getElementById("btn-internet").style.color="#333333";
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
        //document.getElementById("btn-internet").style.color="#039BE5";
        for (var i = 0; i < inputsCable.length; i++) {
            inputsCable[i].disabled = true;
        }
    }

}

//ENABLE OR DISABLE INTERNET INPUTS FOR CABLE ORDERS
function ordenCable(){
    document.getElementById("tipoServicio").value = "C";
    var inputsInternet = document.getElementsByClassName("internet");
    if (inputsInternet[0].disabled == true || inputsInternet[0].readOnly == true) {
        //document.getElementById("btn-cable").style.color="#333333";
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

}

// CHANGE FORM COMPORT
function nuevaOrden(){
    var creadoPor = document.getElementById("creadoPor").value;
    //document.getElementById("btn-cable").disabled = false;
    //document.getElementById("btn-internet").disabled = false;
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

    today = dd + '/' + mm + '/' + yyyy;
    document.getElementById("fechaOrden").value = today;
    //document.getElementById("hora").value = time;
    //document.getElementById("tipoOrden").value = "Técnica";
    document.getElementById("editar").disabled = true;
    document.getElementById("agregarGestion").disabled = false;
    //document.getElementById("nombreOrden").style.display = "none";
    changeAction("nueva");
}

function editarOrden(){
    //document.getElementById("btn-cable").disabled = false;
    document.getElementById("guardar").disabled = false;
    //document.getElementById("btn-internet").disabled = false;
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
    //  document.getElementById("saldoCable").readOnly = true;
    document.getElementById("agregarGestion").disabled = false;
    document.getElementById("saldo").readOnly = true;
    document.getElementById("diaCobro").readOnly = true;
    //document.getElementById("nodo").readOnly = true;
    //document.getElementById("codigoCliente").readOnly = true;
    //document.getElementById("colilla").readOnly = true;
    //document.getElementById("velocidad").disabled = true;
    //document.getElementById("macModem").readOnly = true;
    //document.getElementById("serieModem").readOnly = true;
    //document.getElementById("fechaOrden").readOnly = true;
    document.getElementById("nombreCliente").readOnly = true;

    document.getElementById("nombreOrden").style.display = "run-in";

    changeAction("editar");
}

function changeAction(action){
    switch (action) {
        case "nueva":
            document.getElementById("gestionCobros").action = "php/nuevaGestionCobros.php";
            break;
        case "editar":
            document.getElementById("gestionCobros").action = "php/editarGestionCobros.php";
            break;
        default:

    }
}

function imprimirOrden(){
    var nOrden = document.getElementById("numeroTraslado").value
    // Trigger the button element with a click
    window.open("ordenTrasladoImp.php?nOrden="+nOrden, '_blank');
}

function guardarOrden(){
    //var token = document.getElementById("tipoServicio").value;
    //if (token == "C" || token == "I") {
        document.getElementById('guardar2').click();
    //}else {
        //alert("Por favor indique si la orden es de cable o de internet");
    //}
}

function estadoCuenta(){
    var cod = document.getElementById("codigoCliente").value;
    window.open("estadoCuenta.php?codigoCliente="+cod, '_blank');
}
