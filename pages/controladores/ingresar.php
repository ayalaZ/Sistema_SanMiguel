<?php
require('../../php/permissions.php');
require('../../php/modulePermissions.php');
if ($_POST) {
  if ($_POST['sucursal'] == 2) {
    include_once "../config/_conexion.php";
    $db = "satpro";
  }
  $user = $_POST["user"];
  $pass = $_POST['pass'];
  $consulta = _query("SELECT * FROM tbl_usuario WHERE usuario='$user'");
  $numero = _num_rows($consulta);
  if ($numero > 0) {
    $datos_de_usuario = _fetch_array($consulta);
    if (password_verify($pass, $datos_de_usuario['clave'])) {
      session_start([
        'cookie_lifetime' => 86400,
      ]);

      $_SESSION["id"] = $datos_de_usuario["idUsuario"];
      $_SESSION["user"] = $user;
      $_SESSION["rol"] = $datos_de_usuario["rol"];
      $_SESSION["nombre"] = $datos_de_usuario["nombre"];
      $_SESSION["db"] = $db;
      $totalPermissionsCheck = new Permissions();
      $totalModulePermissionsCheck = new ModulePermissions();
      $_SESSION['permisosTotales'] = $totalPermissionsCheck->getPermissions($_SESSION['id']);
      $_SESSION['permisosTotalesModulos'] = $totalModulePermissionsCheck->getPermissions($_SESSION['id']);

      $xdatos['typeinfo'] = 'success';
      $xdatos['msg'] = 'Exito datos correctos';
    } else {
      $xdatos['typeinfo'] = 'error';
      $xdatos['msg'] = 'Contraseña incorrecta';
    }
  } else {
    $xdatos['typeinfo'] = 'error';
    $xdatos['msg'] = 'El usuario no existe';
  }
  echo json_encode($xdatos);
}
