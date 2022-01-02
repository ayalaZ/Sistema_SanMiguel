<?php
    require '../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;
	require("../php/getInventoryPDF.php");

        $Bodega = $_POST["bodega11"];
        $Nombre = $_POST["NOMBRE"];
        $Apellido = $_POST["APELLIDO"];
        $Todo = $_POST["todo"];
        $getInventoryPDF = new GetInventoryPDF();
        $showInventoryTranslateReport = $getInventoryPDF->getInventoryTranslateReportI($Bodega,$Todo);
	try {
            ob_start();
              $pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(20, 15, 10, 30));
           //Izquierda, Arriba, no se, abajo
            $content = '
            <div >
                <table border="1" WIDTH="100" HEIGHT="100" >
                  <tr>
                      <td colspan="12" align="center"><img src="../images/Cablesat.png"/></td>
                  </tr>
                  <tr>
                      <td colspan="12" HEIGHT="35" align="center" font >ARTICULOS DE INVENTARIO INTERNET</td>
                  </tr>';
            $salir = false;
            foreach( $showInventoryTranslateReport as $res)
          {
            date_default_timezone_set('America/El_Salvador');
            $content .=
                       '<tr>
                       <td COLSPAN="2" width="150" HEIGHT="20" >Nombre de Empleado:</td>
                            <td colspan="4" width="240">'.$Nombre.' '.$Apellido.'</td>
                            <td COLSPAN="2" width="100">Fecha:</td>
                            <td colspan="4" width="110">'. date('Y/m/d g:ia') .'</td>
                            </tr>
                  ';
                       $salir = true;
                      if($salir==true){  break; }
                  }
 // <td COLSPAN="2" width="40" HEIGHT="5" align="center">Codigo</td>
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="16" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>

                             <td colspan="6" width="85" HEIGHT="5" align="center" >Marca</td>
                             <td COLSPAN="2" width="80" HEIGHT="5" align="center" >Modelo</td>
                             <td COLSPAN="2" width="115" HEIGHT="5" align="center" >MAC</td>
                             <td COLSPAN="2" width="125" HEIGHT="5" align="center" >Serie</td>
                             <td COLSPAN="2" width="75" HEIGHT="5" align="center" >Estado</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Descripcion</td>

                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {

                   $content .=
                       '<tr>
                            <td colspan="6" width="85" HEIGHT="5" align="center" >'.  $res["Marca"] .'</td>
                            <td COLSPAN="2" width="80" HEIGHT="5" align="center">'.  $res["Modelo"].'</td>
                           <td COLSPAN="2" width="115" HEIGHT="5" align="center">'.  $res["Mac"].'</td>
                           <td COLSPAN="2" width="125" HEIGHT="5" align="center">'.  $res["serie"].'</td>
                               <td COLSPAN="2" width="75" HEIGHT="5" align="center">';

                                if( $res["Estado"] == 0)
                                {
                                $content .=   'Bueno';
                                }
                                else if( $res["Estado"] == 1)
                                {
                                $content .=   'Regular';
                                }
                                else if( $res["Estado"] == 2)
                                {
                                $content .=   'Quemado';
                                }
                                else if( $res["Estado"] == 3)
                                {
                                $content .=   'Defectuoso';
                                }
                                $content .=
                                '</td>
                                <td COLSPAN="2" width="90" HEIGHT="5" align="center">'.  $res["Descripcion"].'</td>
                        </tr>
                      ';
                   }
               $content .=
                    '</table>
               </div>';

		$pdf -> WriteHTML($content, true, 0, true, 0);
		$pdf -> Output('Generar_PDF.pdf');
        }
        catch (HTML2PDF_exception $e)
        {
            echo $e;
            exit;
        }
?>
