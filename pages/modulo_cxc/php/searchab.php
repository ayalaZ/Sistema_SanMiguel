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
$query = "SELECT idAbono, numeroRecibo, codigoCliente, codigoCobrador, fechaAbonado, tipoServicio, anulada FROM tbl_abonos ORDER BY numeroRecibo ASC LIMIT 5";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT idAbono, numeroRecibo, codigoCliente, codigoCobrador, fechaAbonado, tipoServicio, anulada FROM tbl_abonos
	WHERE numeroRecibo LIKE '%".$q."%' OR codigoCliente LIKE '%".$q."%' OR codigoCobrador LIKE '%".$q."%' OR fechaAbonado LIKE '%".$q."%' ORDER BY numeroRecibo ASC LIMIT 10";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {
 	$salida.="<br><table class='table'>
			    <thead>
					<tr>
						<th>N° RECIBO</th>
						<th>CODIGO CLIENTE</th>
						<th>CODIGO COBRADOR</th>
                        <th>FECHA ABONADO</th>
                        <th>SERVICIO</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
        if ($fila['anulada'] == 0) {
            $salida.= "<tr>
    			<td>"."<a class='btn btn-danger btn-sm' href=consultarAbonos.php?idAbono={$fila['idAbono']}>".$fila['numeroRecibo']."<a></td>
    			<td>".$fila['codigoCliente']."</td>
    			<td>".$fila['codigoCobrador']."</td>
                <td>".$fila['fechaAbonado']."</td>
                <td>".$fila['tipoServicio']."</td>
    		</tr>";
        }
        elseif ($fila['anulada'] == 1) {
            $salida.= "<tr>
    			<td>"."<a class='btn btn-danger btn-sm' href=consultarAbonos.php?idAbono={$fila['idAbono']}>".$fila['numeroRecibo']."<a></td>
    			<td>".$fila['codigoCliente']."</td>
    			<td>".$fila['codigoCobrador']."</td>
                <td>".$fila['fechaAbonado']."</td>
                <td>".$fila['tipoServicio']."</td>
    		</tr>";
        }
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
