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
$query = "SELECT idVendedor, nombresVendedor, apellidosVendedor FROM tbl_vendedores ORDER BY idVendedor ASC LIMIT 5";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT idVendedor, nombresVendedor, apellidosVendedor FROM tbl_vendedores
	WHERE idVendedor LIKE '%".$q."%' OR nombresVendedor LIKE '%".$q."%' OR apellidosVendedor LIKE '%".$q."%' ORDER BY idVendedor ASC LIMIT 10";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {
 	$salida.="<br><table class='table table-striped table-responsive'>
			    <thead>
					<tr class='success'>
						<th>CODIGO</th>
						<th>NOMBRE</th>
						<th>APELLIDO</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<tr>
			<td>"."<a class='btn btn-primary btn-sm' href=vendedores.php?codigoVendedor={$fila['idVendedor']}>".$fila['idVendedor']."<a></td>
			<td>".$fila['nombresVendedor']."</td>
			<td>".$fila['apellidosVendedor']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
