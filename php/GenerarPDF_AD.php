<?php
    session_start();
 ?>
<?php
        require '../vendor/autoload.php';
        use Spipu\Html2Pdf\Html2Pdf;
        //Consulta del Reporte y detalle a la BD
        require("getViewA_D.php");
        $detalleAsignacion = new GetViewA_D();
        $a=$_POST['Id'];
        $detalleAsigna = $detalleAsignacion->detalleAsignacionesRealizadas($a);
	try {

		ob_start();
        $pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(20, 15, 10, 10));
       //Izquierda, Arriba, abajo
       //Llenar tablas
        $content = '
            <table border="1" WIDTH="100" HEIGHT="100" >
              <tr>
                  <td colspan="12" align="center"><img src="../images/Cablesat.png" HEIGHT="100" /></td>
              </tr>
              <tr>
                  <td colspan="12" HEIGHT="35" align="center" font >DETALLE DE TRASLADO DE ARTICULOS</td>
              </tr>
              <tr>
               <td colspan="12" HEIGHT="30" align="center" font><b>Informacion de quien Realizo el Traslado</b></td>
           </tr>
              ';
        $salir = false;
        foreach($detalleAsigna as $res)
          {
            $content .= '
         <tr>
             <td COLSPAN="2" width="150" HEIGHT="20" > <b>Nombre del Empleado:</b></td>
             <td colspan="4" width="250">'. $res["NombreEmpleadoEnvia"] .' </td>
             <td COLSPAN="2" width="100"><b>Código del Empleado:</b></td>
             <td colspan="4" width="100">'. $res["CodigoEmpleadoEnvia"] .'</td>
          </tr>
            <tr>
              <td COLSPAN="2" width="150" HEIGHT="20"><b>Bodega Origen:</b></td>
              <td colspan="4" width="250">'. $res["NombreBodega"] .'</td>
              <td COLSPAN="2" width="100"><b>Fecha y Hora De Envìo:</b></td>
              <td colspan="4" width="100">'. $res["FechaEnvia"] .'</td>
          </tr>
          <tr>
               <td colspan="12" HEIGHT="15" align="center">Comentario:</td>
          </tr>
          <tr>
               <td colspan="12" HEIGHT="15" >'. $res["ComentarioEnvio"].'</td>
          </tr>
              <tr>
              <td colspan="12" HEIGHT="30" align="center" font><b>Informacion de quien Recibió el Traslado</b></td>
          </tr>
            <tr>
             <td COLSPAN="2" width="150" HEIGHT="20" ><b>Nombre del Empleado:</b></td>
             <td colspan="4" width="250">'. $res["NombreEmpleadoRecibe"] .' </td>
             <td COLSPAN="2" width="100"><b>Código del Empleado:</b></td>
             <td colspan="4" width="100">'. $res["CodigoEmpleadoRecibe"] .'</td>
          </tr>
            <tr>
              <td COLSPAN="2" width="150" HEIGHT="20"><b>Departamento:</b></td>
              <td colspan="4" width="250">'. $res["DepartamentoRecibe"] .'</td>
              <td COLSPAN="2" width="100"><b>Fecha y Hora de Recibido:</b></td>
              <td colspan="4" width="100">'. $res["FechaRecibe"]. '</td>
          </tr>
          <tr>
               <td colspan="12" HEIGHT="15" align="center">Comentario:</td>
          </tr>
          <tr>
               <td colspan="12" HEIGHT="15" >'. $res["ComentarioRecibe"].'</td>
          </tr>
            ';
           $salir = true;
            if($salir==true){  break; }
            }

            $content .= '
            </table>
            <br>
             <table border="1" WIDTH="100" HEIGHT="100">
             <tr>
                 <td colspan="12" HEIGHT="15" align="center" font >DESCRIPCION</td>
             </tr>
             <tr>
                 <td COLSPAN="2" width="100" HEIGHT="5" align="center"><b>Codigo Producto</b></td>
                 <td colspan="4" width="410" HEIGHT="5" align="center"><b>Nombre Producto</b> </td>
                 <td COLSPAN="6" width="100" HEIGHT="5" align="center" ><b>Cantidad</b></td>
             </tr>
            ';
            foreach( $detalleAsigna as $res)
            {
            $content .= '
                <tr>
                   <td COLSPAN="2" width="100" HEIGHT="10" align="center">'.$res["CodigoArticulo"].'</td>
                    <td colspan="4" width="410" align="center">'.$res["NombreArticulo"].'</td>
                    <td COLSPAN="6" width="100" align="center">'. $res["Cantidad"].'</td>
                </tr>
                </table>
            ';
            }


        //Escribir tablas sobre PDF
	   $pdf->writeHTML($content, true, 0, true, 0);
		$pdf -> Output('Reporte_Confirmado.pdf');
	}
    catch (HTML2PDF_exception $e)
    {
		echo $e;
		exit;
	}
?>
