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
$query = "SELECT idOrdenTrabajo, codigoCliente, nombreCliente, direccionCable, direccionInter, fechaOrdenTrabajo, macModem, mactv, serieModem, observaciones FROM tbl_ordenes_trabajo ORDER BY idOrdenTrabajo LIMIT 7";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT idOrdenTrabajo, codigoCliente, nombreCliente, direccionCable, direccionInter, fechaOrdenTrabajo, macModem, mactv, serieModem, observaciones FROM tbl_ordenes_trabajo
	          WHERE idOrdenTrabajo LIKE '%".$q."%' OR codigoCliente LIKE '%".$q."%' OR nombreCliente LIKE '%".$q."%' OR direccionCable LIKE '%".$q."%' OR direccionInter LIKE '%".$q."%' OR fechaOrdenTrabajo LIKE '%".$q."%'
              OR macModem LIKE '%".$q."%' OR mactv LIKE '%".$q."%' OR serieModem LIKE '%".$q."%' OR observaciones LIKE '%".$q."%' LIMIT 5";
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
                        <th>DIRECCION CABLE</th>
                        <th>DIRECCION INTER</th>
                        <th>MAC MODEM</th>
                        <th>SERIAL</th>
                        <th>MAC TV</th>
                        <th>OBSERVACIONES</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<tr>
			<td>"."<a class='btn btn-primary btn-sm' href=ordenTrabajo.php?nOrden={$fila['idOrdenTrabajo']}>".$fila['idOrdenTrabajo']."<a></td>
			<td>".$fila['codigoCliente']."</td>
			<td>".$fila['nombreCliente']."</td>
            <td>".$fila['fechaOrdenTrabajo']."</td>
            <td>".$fila['direccionCable']."</td>
            <td>".$fila['direccionInter']."</td>
            <td>".$fila['macModem']."</td>
            <td>".$fila['serieModem']."</td>
            <td>".$fila['mactv']."</td>
            <td>".$fila['observaciones']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
