<?php

require_once "../../../php/config.php";
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
$query = "SELECT id_empleado, nombres, apellidos, nombre_isss, direccion FROM tbl_empleados ORDER BY id_empleado LIMIT 0";
 if (isset($_POST['consulta'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
	$query = "SELECT id_empleado, nombres, apellidos, nombre_isss, direccion FROM tbl_empleados
	          WHERE id_empleado LIKE '%".$q."%' OR nombres LIKE '%".$q."%' OR apellidos LIKE '%".$q."%' OR nombre_isss LIKE '%".$q."%' OR direccion LIKE '%".$q."%' LIMIT 5";
 }

 $resultado = $mysqli->query($query);
 if ($resultado->num_rows > 0) {
 	$salida.="<br><table style='font-size:12px;' class='table table-striped table-responsive'>
			    <thead>
					<tr class='active'>
						<th>ID</th>
						<th>NOMBRES</th>
                        <th>APELLIDOS</th>
                        <th>NOMBRE SEGÚN ISSS</th>
                        <th>DIRECCION</th>
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<tr>
			<td>"."<a class='btn btn-primary btn-sm' href=empleados.php?idEmpleado={$fila['id_empleado']}>".$fila['id_empleado']."<a></td>
			<td>".$fila['nombres']."</td>
			<td>".$fila['apellidos']."</td>
            <td>".$fila['nombre_isss']."</td>
            <td>".$fila['direccion']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();
