const AGREGAR = 1;
const EDITAR = 2;
const ELIMINAR = 4;
const GENERCONTRATO =8;
const IMPCONTRATO =16;


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
    var imprimirC = document.getElementsByName('imprimir');
    for (var i = 0; i < editElements.length; i++) {
        editElements[i].disabled = false;
        imprimirC[i].disabled = false;
    }
}
else {
    var editElements = document.getElementsByName('editar');
    var imprimirC = document.getElementsByName('imprimir');
    for (var i = 0; i < editElements.length; i++) {
        if(editElements[i].tagName = 'li'){
            editElements[i].style.display = 'none';
            imprimirC[i].style.display = 'none';
        }
        editElements[i].disabled = true;
        imprimirC[i].disabled = true;
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

//Si el usuario tiene permiso de GENERAR CONTRATOS, podrá crearlo, sino se deshabilitan la opción.
if (getAccess(permisos, GENERCONTRATO)) {
    var generarC = document.getElementsByName('generarCont');
    var gestCont = document.getElementsByName('gestionCont');
    for (var i = 0; i < generarC.length; i++) {
        generarC[i].disabled = false;
    }
    for (var i = 0; i < gestCont.length; i++) {
        gestCont[i].disabled = false;
    }
}
else {
    var generarC = document.getElementsByName('generarCont');
    var gestCont = document.getElementsByName('gestionCont');
    for (var i = 0; i < generarC.length; i++) {
        if(generarC[i].tagName = 'li'){
            generarC[i].style.display = 'none';
        }
        generarC[i].disabled = true;
    }
     for (var i = 0; i < gestCont.length; i++) {
        gestCont[i].disabled = true;
    }
}

//Si el usuario tiene permiso de IMPRIMIR contratos, podrá realizarlo, sino se deshabilitan la opción.
if (getAccess(permisos, IMPCONTRATO)) {
    var imprimirC = document.getElementsByName('imprimir');
    for (var i = 0; i < imprimirC.length; i++) {
        imprimirC[i].disabled = false;
    }
}
else {
    var imprimirC = document.getElementsByName('imprimir');
    for (var i = 0; i < imprimirC.length; i++) {
        if(imprimirC[i].tagName = 'li'){
            imprimirC[i].style.display = 'none';
        }
        imprimirC[i].disabled = true;
    }
}
