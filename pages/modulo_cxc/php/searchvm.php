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
$query = "SELECT idVenta, numeroComprobante, fechaComprobante, codigoCliente, nombreCliente, direccionCliente, impuesto, anulada FROM tbl_ventas_manuales ORDER BY idVenta ASC LIMIT 5";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT idVenta, numeroComprobante, fechaComprobante, codigoCliente, nombreCliente, direccionCliente, impuesto, anulada FROM tbl_ventas_manuales
	WHERE numeroComprobante LIKE '%".$q."%' OR fechaComprobante LIKE '%".$q."%' OR codigoCliente LIKE '%".$q."%' OR nombreCliente LIKE '%".$q."%' OR direccionCliente LIKE '%".$q."%' OR impuesto LIKE '%".$q."%' ORDER BY idVenta ASC LIMIT 10";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {
 	$salida.="<br><table class='table table-striped table-responsive'>
			    <thead>
					<tr class='success'>
                        <th>N° VENTA</th>
						<th>N° COMPROBANTE</th>
						<th>FECHA COMPROBANTE</th>
						<th>CODIGO CLIENTE</th>
                        <th>NOMBRE</th>
                        <th>DIRECCIÓN</th>
                        <th>IMPUESTO</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
        if ($fila['anulada'] == 0) {
            $salida.= "<tr>
    			<td>"."<a class='btn btn-primary btn-sm' href=ventasManuales.php?idVenta={$fila['idVenta']}>".$fila['idVenta']."<a></td>
    			<td>".$fila['numeroComprobante']."</td>
                <td>".$fila['fechaComprobante']."</td>
    			<td>".$fila['codigoCliente']."</td>
                <td>".$fila['nombreCliente']."</td>
                <td>".$fila['direccionCliente']."</td>
                <td>"."$".number_format($fila['impuesto'],2)."</td>
    		</tr>";
        }
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
