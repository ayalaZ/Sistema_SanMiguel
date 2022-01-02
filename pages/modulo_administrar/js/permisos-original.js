const AGREGAR = 1;
const EDITAR = 2;
const ELIMINAR = 4;

function getAccess(permisosActuales, permisoRequerido){
    return ((parseInt(permisosActuales) & parseInt(permisoRequerido)) == 0) ? false : true;
}

//Si el usuario tiene permiso de AGREGAR, podrá agregar datos, sino se deshabilitan las opciones
if (getAccess(permisos, AGREGAR)) {
    var agregElements = document.getElementsByName('agregar');
    for (var i = 0; i < agregElements.length; i++) {
        agregElements[i].disabled = false;
    }
}
else {
    var agregElements = document.getElementsByName('agregar');
    for (var i = 0; i < agregElements.length; i++) {
        if(agregElements[i].tagName = 'li'){
            agregElements[i].style.display = 'none';
        }
        agregElements[i].disabled = true;
    }
}
//Si el usuario tiene permiso de EDITAR, podrá modificar datos, sino se deshabilitan las opciones
if (getAccess(permisos, EDITAR)) {
    var editElements = document.getElementsByName('editar');
    for (var i = 0; i < editElements.length; i++) {
        editElements[i].disabled = false;
    }
}
else {
    var editElements = document.getElementsByName('editar');
    for (var i = 0; i < editElements.length; i++) {
        if(editElements[i].tagName = 'li'){
            editElements[i].style.display = 'none';
        }
        editElements[i].disabled = true;
    }
}
//Si el usuario tiene permiso de ELIMINAR, podrá modificar datos, sino se deshabilitan las opciones
if (getAccess(permisos, ELIMINAR)) {
    var deleteElements = document.getElementsByName('eliminar');
    for (var i = 0; i < deleteElements.length; i++) {
        deleteElements[i].disabled = false;
    }
}
else {
    var deleteElements = document.getElementsByName('eliminar');
    for (var i = 0; i < deleteElements.length; i++) {
        if(deleteElements[i].tagName = 'li'){
            deleteElements[i].style.display = 'none';
        }
        deleteElements[i].disabled = true;
    }
}
