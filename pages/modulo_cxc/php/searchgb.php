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
$query = "SELECT idGestionGeneral, codigoCliente, nombreCliente, direccion, telefonos FROM tbl_gestion_general ORDER BY codigoCliente ASC LIMIT 5";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT idGestionGeneral, codigoCliente, nombreCliente, direccion, telefonos FROM tbl_gestion_general
	WHERE codigoCliente LIKE '%".$q."%' OR nombreCliente LIKE '%".$q."%' OR direccion LIKE '%".$q."%' OR telefonos LIKE '%".$q."%' ORDER BY codigoCliente ASC LIMIT 10";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {
 	$salida.="<br><table class='table table-striped table-responsive'>
			    <thead>
					<tr class='success'>
						<th>ID GESTION</th>
						<th>CODIGO CLIENTE</th>
						<th>NOMBRE CLIENTE</th>
                        <th>DIRECCION</th>
                        <th>TELEFONOS</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
        $salida.= "<tr>
            <td><a class='btn btn-primary' href=gestionCobros.php?idGestion={$fila['idGestionGeneral']}>".$fila['idGestionGeneral']."</a></td>
			<td>".$fila['codigoCliente']."</td>
			<td>".$fila['nombreCliente']."</td>
            <td>".$fila['direccion']."</td>
            <td>".$fila['telefonos']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
