<?php
    session_start();
 ?>
<?php
        require '../vendor/autoload.php';
        use Spipu\Html2Pdf\Html2Pdf;
        //Consulta del Reporte y detalle a la BD
        require("reportsPDF.php");
        $reports = new Reports();
        $a= $_GET['v'];
        $showInventoryTranslateReport = $reports->getInventoryTranslateReport($a);
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
                  <td colspan="12" HEIGHT="35" align="center" font >REPORTE DE TRASLADO DE PRODUCTOS</td>
              </tr>
              <tr>
               <td colspan="12" HEIGHT="30" align="center" font><b>Informacion de quien Realizo el Traslado</b></td>
           </tr>
              ';
        $salir = false;
        foreach($showInventoryTranslateReport as $res)
          {
            $content .= '
             <tr>
                 <td COLSPAN="2" width="150" HEIGHT="20" >Nombre del Empleado:</td>
                 <td colspan="4" width="250">'. $res["NombreEmpleadoOrigen"]. '</td>
                 <td COLSPAN="2" width="100">Código del Empleado</td>
                 <td colspan="4" width="100">'. $res["CodigoEmpleadoOrigen"]. '</td>
              </tr>
                <tr>
                   <td COLSPAN="2" width="150" HEIGHT="20">Bodega Origen:</td>
                  <td colspan="4" width="250">'. $res["BodegaOrigen"].'</td>
                  <td COLSPAN="2" width="100">Fecha y Hora De Envìo:</td>
                  <td colspan="4" width="100">' .$res["FechaOrigen"].'</td>
              </tr>
              <tr>
                   <td COLSPAN="12" HEIGHT="15" align="center">Comentario:</td>
              </tr>
              <tr>
                   <td COLSPAN="12" HEIGHT="25" >'. $res["Razon"].'</td>
              </tr>
              <tr>
              <td colspan="12" HEIGHT="30" align="center" font><b>Informacion de quien Recibió el Traslado</b></td>
          </tr>
               <tr>
                  <td COLSPAN="2" width="150" HEIGHT="20" >Nombre del Empleado:</td>
                 <td colspan="4" width="250">'. $res["NombreEmpleadoDestino"]. '</td>
                 <td COLSPAN="2" width="100">Código del Empleado</td>
                 <td colspan="4" width="100">'. $res["CodigoEmpleadoDestino"]. '</td>
              </tr>
               <tr>
                  <td COLSPAN="2" width="150" HEIGHT="20">Bodega Destino:</td>
                  <td colspan="4" width="250">'. $res["BodegaDestino"].'</td>
                  <td COLSPAN="2" width="100">Fecha y Hora De Recepciòn:</td>
                  <td colspan="4" width="100">' .$res["FechaDestino"].'</td>
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
                  <td COLSPAN="2" width="100" HEIGHT="5" align="center">Codigo Producto</td>
                  <td colspan="4" width="410" HEIGHT="5" >Nombre Producto </td>
                  <td COLSPAN="6" width="100" HEIGHT="5" align="center" >Cantidad</td>
              </tr>
            ';
            foreach( $showInventoryTranslateReport as $res)
            {
            $content .= '
                <tr>
                   <td COLSPAN="2" width="100" HEIGHT="10" align="center">'.$res["CodigoArticulo"].'</td>
                    <td colspan="4" width="410" align="center" >'.$res["NombreArticulo"].'</td>
                    <td COLSPAN="6" width="100" align="center">'. $res["cantidad"].'</td>
                </tr>
                </table>
            ';
            }


        //Escribir tablas sobre PDF
	   $pdf->writeHTML($content, true, 0, true, 0);
		$pdf -> Output('Generar_PDF.pdf');
	}
    catch (HTML2PDF_exception $e)
    {
		echo $e;
		exit;
	}
?>
