// CHANGE FORM COMPORT
function nuevoEmpleado(){
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
    document.getElementById("guardar").disabled = false;
    document.getElementById("editarEmpleado").disabled = true;
    var ultimoId = document.getElementById("ultimoId").value;
    document.getElementById("idEmpleado").value = parseInt(ultimoId);
    changeAction("nueva");
}
function editarEmpleado(){
    var editInputs = document.getElementsByClassName("input-sm");
    for (var i = 0; i < editInputs.length; i++) {
        if (editInputs[i].readOnly == true) {
            editInputs[i].readOnly = false;
        }
        else if (editInputs[i].disabled == true){
            editInputs[i].disabled = false;
        }
    }
    document.getElementById("nuevoEmpleado").disabled = true;
    document.getElementById("guardar").disabled = false;
    changeAction("editar");
}

function changeAction(action){
    switch (action) {
        case "nueva":
            document.getElementById("empleados").action = "php/newEmployee.php";
            break;
        case "editar":
            document.getElementById("empleados").action = "php/editEmployee.php";
            break;
        default:

    }
}
