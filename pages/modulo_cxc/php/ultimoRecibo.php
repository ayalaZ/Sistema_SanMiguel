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

 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT codigoCobrador, numeroAsignador FROM tbl_cobradores
	WHERE codigoCobrador LIKE '".$q."%' ORDER BY codigoCobrador";

    $resultado = $mysqli->query($query);

    if ($resultado->num_rows > 0) {

   	while ($fila = $resultado->fetch_assoc()) {
           //<input style='color:#000;' id='ultimoRecibo' class='form-control input-sm input-sm alert-warning' type='text' name='ultimoRecibo' value=".$fila['numeroAsignador']." required>;
   		$salida.= "<label for='ultimoRecibo'>N° recibo a ingresar</label><input style='color:#000;' class='form-control input-sm input-sm alert-warning' type='text' name='ultimoRecibo' value=".$fila['numeroAsignador']." required>";
   	}

   }else {
   	$salida.= "<input style='color:#000;' class='form-control input-sm input-sm alert-warning' type='text' name='ultimoRecibo' value='' required>";
   }
 }


echo $salida;
$mysqli->close();
