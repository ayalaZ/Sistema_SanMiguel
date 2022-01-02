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
$query = "SELECT idOrdenTraslado, codigoCliente, nombreCliente, direccion, fechaOrden FROM tbl_ordenes_traslado ORDER BY idOrdenTraslado LIMIT 0";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT idOrdenTraslado, codigoCliente, nombreCliente, direccion, fechaOrden FROM tbl_ordenes_traslado
	          WHERE idOrdenTraslado LIKE '%".$q."%' OR codigoCliente LIKE '%".$q."%' OR nombreCliente LIKE '%".$q."%' OR direccion LIKE '%".$q."%' OR fechaOrden LIKE '%".$q."%' LIMIT 5";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {
 	$salida.="<br><table style='font-size:12px;' class='table table-striped table-responsive'>
			    <thead>
					<tr class='active'>
						<th>#Orden</th>
						<th>CODIGO CLIENTE</th>
						<th>NOMBRE</th>
                        <th>FECHA ORDEN</th>
                        <th>DIRECCION</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<tr>
			<td>"."<a class='btn btn-primary btn-sm' href=ordenTraslado.php?nOrden={$fila['idOrdenTraslado']}>".$fila['idOrdenTraslado']."<a></td>
			<td>".$fila['codigoCliente']."</td>
			<td>".$fila['nombreCliente']."</td>
            <td>".$fila['fechaOrden']."</td>
            <td>".$fila['direccion']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
