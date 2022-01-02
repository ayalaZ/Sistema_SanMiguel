<?php

require_once("../../../php/config.php");
if(!isset($_SESSION))
{
    session_start();
}
$host = DB_HOST;
$user = DB_USER;
$password = DB_PASSWORD;
$database = $_SESSION['db'];

$mysqli = new mysqli($host, $user, $password, $database);

$salida = "";
$query = "SELECT idMunicipio, nombreMunicipio FROM tbl_municipios_cxc ORDER BY idMunicipio";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT idMunicipio, nombreMunicipio FROM tbl_municipios_cxc
	WHERE idMunicipio LIKE '".$q."%' ORDER BY idMunicipio";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {

	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<option value=".$fila['idMunicipio']." selected>".$fila['nombreMunicipio']."</option>";
	}

}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
