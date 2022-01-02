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
$query = "SELECT codigoCobrador, nombreCobrador, desdeNumero, hastaNumero, numeroAsignador FROM tbl_cobradores ORDER BY codigoCobrador ASC LIMIT 5";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT codigoCobrador, nombreCobrador, desdeNumero, hastaNumero, numeroAsignador FROM tbl_cobradores
	WHERE codigoCobrador LIKE '%".$q."%' OR nombreCobrador LIKE '%".$q."%' OR desdeNumero LIKE '%".$q."%' OR hastaNumero LIKE '%".$q."%' OR numeroAsignador LIKE '%".$q."%' ORDER BY codigoCobrador ASC LIMIT 10";
 }

 $resultado = $mysqli->query($query);

 if ($resultado->num_rows > 0) {
 	$salida.="<br><table class='table table-striped table-responsive'>
			    <thead>
					<tr class='success'>
						<th>CODIGO</th>
						<th>NOMBRE</th>
						<th>NUMERO DESDE</th>
                        <th>NUMERO HASTA</th>
                        <th>ULTIMO NUMERO</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<tr>
			<td>"."<a class='btn btn-primary btn-sm' href=cobradores.php?codigoCobrador={$fila['codigoCobrador']}>".$fila['codigoCobrador']."<a></td>
			<td>".$fila['nombreCobrador']."</td>
			<td>".$fila['desdeNumero']."</td>
            <td>".$fila['hastaNumero']."</td>
            <td>".$fila['numeroAsignador']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
