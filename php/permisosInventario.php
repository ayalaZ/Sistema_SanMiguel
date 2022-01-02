<?php
function setPermisos(){
    if(!isset($_SESSION["user"])) {
        header('Location: login.php');
    }
     // session_start();
     if(isset($_SESSION["user"])) {
         if ($_SESSION["rol"] != "administracion" && $_SESSION["rol"] != "subgerencia" && $_SESSION["rol"] != "headen" && $_SESSION["rol"] != "jefatura") {
             echo "<script>
                        alert('No tienes permisos para ingresar a esta área');
                        window.location.href='moduloInventario.php';
                   </script>";
         }
     }
}
?>
