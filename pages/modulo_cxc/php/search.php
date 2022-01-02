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
$searchCable = '%';
$searchInter = '%';
$salida = "";
/*$filtroBusqueda = $_POST["filtroBusqueda"];*/

$query = "SELECT cod_cliente, numero_dui, nombre, direccion, telefonos, Mac_modem, Serie_modem, Dire_telefonia FROM clientes where cod_cliente <> '00000' AND (servicio_suspendido IS NULL OR servicio_suspendido LIKE '{$searchCable}' OR servicio_suspendido LIKE '{$searchCable}') ORDER BY cod_cliente LIMIT 7";

 if (isset($_POST['consulta']) && isset($_POST['mun']) && isset($_POST['col']) && isset($_POST['cable']) && isset($_POST['inter'])) {
 	$q = $mysqli->real_escape_string($_POST['consulta']);
 	$m = $mysqli->real_escape_string($_POST['mun']);
 	$c = $mysqli->real_escape_string($_POST['col']);
 	$ca = $mysqli->real_escape_string($_POST['cable']);
 	$in = $mysqli->real_escape_string($_POST['inter']);
 	if ($ca == 't'){
 	    //$ca = "";
        $ca = " AND (servicio_suspendido IS NULL OR servicio_suspendido = 'F' OR servicio_suspendido = '' OR servicio_suspendido = 'T') AND (sin_servicio = 'F' OR sin_servicio='T' OR sin_servicio='')";
    }elseif ($ca == 'a'){
        $ca = " AND (servicio_suspendido IS NULL OR servicio_suspendido = 'F' OR servicio_suspendido = '') AND (sin_servicio = 'F')";
    }elseif ($ca == 's'){
        $ca = " AND (servicio_suspendido = 'T') AND (sin_servicio = 'F')";
    }elseif ($ca == 'na'){
        $ca = " AND (sin_servicio = 'T')";
    }

     if ($in == 't'){
         $in = " AND (estado_cliente_in = 1 OR estado_cliente_in = 2 OR estado_cliente_in = 3)";
     }elseif($in == 'a'){
         $in = " AND (estado_cliente_in = 1)";
     }elseif($in == 's'){
         $in = " AND (estado_cliente_in = 2)";
     }elseif($in == 'na'){
         $in = " AND (estado_cliente_in = 3)";
     }
     /*var_dump($_POST['mun']);
     var_dump($_POST['col']);
     var_dump($_POST['cable']);
     var_dump($_POST['inter']);*/

	$query = "SELECT cod_cliente, numero_dui, nombre, direccion, telefonos, Mac_modem, Serie_modem, Dire_telefonia FROM clientes
	WHERE (cod_cliente LIKE '%".$q."%' OR nombre LIKE '%".$q."%' OR direccion LIKE '%".$q."%' OR Mac_modem LIKE '%".$q."%' OR numero_dui LIKE '%".$q."%')
	AND id_municipio LIKE '".$m."%' AND id_colonia LIKE '".$c."%' {$ca} {$in} AND cod_cliente <> '00000' LIMIT 50";

	//var_dump($query);
 }

 $resultado = $mysqli->query($query);
 //$counter = mysqli_num_rows($resultado);
 if ($resultado->num_rows > 0) {
 	$salida.="<br><table class='table table-hover table-responsive'>
			    <thead>
					<tr style='background-color: #2b2b2b; color: #ffffff;' class='inverse'>
						<th class='th-dark'>CODIGO</th>
						<th>NOMBRE</th>
						<th>DIRECCION</th>
                        <th>TELEFONOS</th>
                        <th>MAC</th>
                        <th>DUI</th>
                        <!--<th>SERIE</th>-->
                        <!--<th>NODO</th>-->
                        <!--<th><span class='badge'></span></th>-->
					</tr>
				</thead>
				<tbody>";
	while ($fila = $resultado->fetch_assoc()) {
		$salida.= "<tr>
			<td>"."<a class='btn btn-danger btn-sm' href=infoCliente.php?id={$fila['cod_cliente']} target='_self'>".$fila['cod_cliente']."<a></td>
			<td>".$fila['nombre']."</td>
			<td>".$fila['direccion']."</td>
            <td>".$fila['telefonos']."</td>
            <td>".$fila['Mac_modem']."</td>
            <td>".$fila['numero_dui']."</td>
		</tr>";
	}
	$salida.="</tbody></table>";
}else {
	$salida.="No se encontraron coincidencias";
}
echo $salida;
$mysqli->close();