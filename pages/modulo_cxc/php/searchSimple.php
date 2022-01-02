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
$query = "SELECT cod_cliente, numero_dui, nombre, direccion, telefonos, wanip, Mac_modem, Serie_modem, Dire_telefonia FROM clientes ORDER BY cod_cliente LIMIT 35";
 if (isset($_POST['consultaSimple'])) {
 	$q = $mysqli->real_escape_string($_POST['consultaSimple']);
	$query = "SELECT cod_cliente, numero_dui, nombre, direccion, telefonos, wanip, Mac_modem, Serie_modem, Dire_telefonia FROM clientes
	WHERE cod_cliente LIKE '%".$q."%' OR numero_dui LIKE '%".$q."%' OR nombre LIKE '%".$q."%' OR direccion LIKE '%".$q."%' OR telefonos LIKE '%".$q."%' OR wanip LIKE '%".$q."%' OR Mac_modem LIKE '%".$q."%' OR Serie_modem LIKE '%".$q."%' OR Dire_telefonia LIKE '%".$q."%' LIMIT 35";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {
 	$salida.="<br><table class='table table-striped table-responsive'>
			    <thead>
					<tr style='background-color: #2b2b2b; color: #ffffff;' class='inverse'>
						<th class='th-dark'>CODIGO</th>
						<th>DUI</th>
						<th>NOMBRE</th>
						<th>DIRECCION</th>
                        <th>TELEFONOS</th>
                        <th>IP</th>
                        <th>MAC</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<tr>
			<td>"."<a class='btn btn-danger btn-sm' href=infoCliente.php?id={$fila['cod_cliente']} target='_self'>".$fila['cod_cliente']."<a></td>
			<td>".$fila['numero_dui']."</td>
			<td>".$fila['nombre']."</td>
			<td>".$fila['direccion']."</td>
            <td>".$fila['telefonos']."</td>
            <td>".$fila['wanip']."</td>
            <td>".$fila['Mac_modem']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
