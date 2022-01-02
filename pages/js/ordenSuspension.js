//ENABLE OR DISABLE CABLE INPUTS FOR INTERNET ORDERS
function ordenInternet(){
    var inputsCable = document.getElementsByClassName("cable");
    if (inputsCable[0].disabled == true) {
        document.getElementById("btn-internet").style.color="#333333";
        for (var i = 0; i < inputsCable.length; i++) {
            inputsCable[i].disabled = false;
        }
    }
    else {
        document.getElementById("btn-internet").style.color="#039BE5";
        for (var i = 0; i < inputsCable.length; i++) {
            inputsCable[i].disabled = true;
        }
    }

}

//ENABLE OR DISABLE INTERNET INPUTS FOR CABLE ORDERS
function ordenCable(){
    var inputsInternet = document.getElementsByClassName("internet");
    if (inputsInternet[0].disabled == true) {
        document.getElementById("btn-cable").style.color="#333333";
        for (var i = 0; i < inputsInternet.length; i++) {
            inputsInternet[i].disabled = false;
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

    today = dd + '/' + mm + '/' + yyyy;

    document.getElementById("fechaOrden").value = today;
    document.getElementById("guardar").disabled = false;
    document.getElementById("editar").disabled = true;
    changeAction("nueva");
}

function editarOrden(){
    var editInputs = document.getElementsByClassName("input-sm");
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
            document.getElementById("ordenSuspension").action = "php/nuevaOrdenSuspension.php";
            break;
        case "editar":
            document.getElementById("ordenSuspension").action = "php/editarOrdenSuspension.php";
            break;
        default:

    }
}
