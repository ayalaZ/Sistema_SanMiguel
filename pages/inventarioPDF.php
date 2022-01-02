<?php
    require '../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;
	require("../php/getInventoryPDF.php");
        $Bodega = $_POST["bodega11"];
        $Proveedor = $_POST["proveedor11"];
        $Nombre = $_POST["NOMBRE"];
        $Apellido = $_POST["APELLIDO"];
        $getInventoryPDF = new GetInventoryPDF();
        $showInventoryTranslateReport = $getInventoryPDF->getInventoryTranslateReport($Bodega, $Proveedor);

	try {
            ob_start();
              $pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(20, 15, 10, 10));
           //Izquierda, Arriba, no se, abajo
            $content = '
            <div >
                <table border="1" WIDTH="100" HEIGHT="100" >
                  <tr>
                      <td colspan="12" align="center"><img src="../images/Cablesat.png"/></td>
                  </tr>
                  <tr>
                      <td colspan="12" HEIGHT="35" align="center" font >ARTICULOS DE INVENTARIO</td>
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


            if(isset($_POST['PrecioVenta'] , $_POST['PrecioCompra'], $_POST['Proveedor'] ) )
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="14" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="50" HEIGHT="5" align="center">Codigo</td>
                             <td colspan="4" width="200" HEIGHT="5" align="center" >Nombre</td>
                             <td COLSPAN="2" width="50" HEIGHT="5" align="center" >Cant</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Precio Compra</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Precio Venta</td>
                             <td COLSPAN="2" width="100" HEIGHT="5" align="center" >Proveedor</td>
                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
                       '<tr>
                            <td COLSPAN="2" width="50" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                            <td colspan="4" width="200" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .'</td>
                            <td COLSPAN="2" width="50" HEIGHT="5" align="center">'.  $res["Cantidad"].'</td>
                           <td COLSPAN="2" width="90" HEIGHT="5" align="center">$ '.  $res["PrecioCompra"].'</td>
                           <td COLSPAN="2" width="90" HEIGHT="5" align="center">$ '.  $res["PrecioVenta"].'</td>
                               <td COLSPAN="2" width="100" HEIGHT="5" align="center">'.  $res["Proveedor"].'</td>
                        </tr>
                      ';
                   }
               $content .=
                    '</table>
               </div>';
            }
            else if(isset($_POST['PrecioVenta'] , $_POST['PrecioCompra'] ) )
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="14" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="60" HEIGHT="5" align="center">Codigo</td>
                             <td colspan="4" width="250" HEIGHT="5" align="center" >Nombre</td>
                             <td COLSPAN="4" width="100" HEIGHT="5" align="center" >Cantidad</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Precio Compra</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Precio Venta</td>

                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
                       '<tr>
                            <td COLSPAN="2" width="60" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                            <td colspan="4" width="250" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .'</td>
                            <td COLSPAN="4" width="100" HEIGHT="5" align="center">'.  $res["Cantidad"].'</td>
                           <td COLSPAN="2" width="90" HEIGHT="5" align="center">$ '.  $res["PrecioCompra"].'</td>
                           <td COLSPAN="2" width="90" HEIGHT="5" align="center">$ '.  $res["PrecioVenta"].'</td>
                        </tr>
                      ';
                   }
               $content .=
                    '</table>
               </div>';
            }
            else if(isset($_POST['PrecioVenta'] , $_POST['Proveedor'] ) )
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="14" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="60" HEIGHT="5" align="center">Codigo</td>
                             <td colspan="4" width="250" HEIGHT="5" align="center" >Nombre</td>
                             <td COLSPAN="4" width="100" HEIGHT="5" align="center" >Cantidad</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Proveedor</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Precio Venta</td>

                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
                       '<tr>
                            <td COLSPAN="2" width="60" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                            <td colspan="4" width="250" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .'</td>
                            <td COLSPAN="4" width="100" HEIGHT="5" align="center">'.  $res["Cantidad"].'</td>
                           <td COLSPAN="2" width="90" HEIGHT="5" align="center"> '.  $res["Proveedor"].'</td>
                           <td COLSPAN="2" width="90" HEIGHT="5" align="center">$ '.  $res["PrecioVenta"].'</td>
                        </tr>
                      ';
                   }
               $content .=
                    '</table>
               </div>';
            }
            else if(isset($_POST['PrecioCompra'] , $_POST['Proveedor'] ) )
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="14" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="60" HEIGHT="5" align="center">Codigo</td>
                             <td colspan="4" width="250" HEIGHT="5" align="center" >Nombre</td>
                             <td COLSPAN="4" width="100" HEIGHT="5" align="center" >Cantidad</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Proveedor</td>
                             <td COLSPAN="2" width="90" HEIGHT="5" align="center" >Precio Compra</td>

                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
                       '<tr>
                            <td COLSPAN="2" width="60" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                            <td colspan="4" width="250" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .'</td>
                            <td COLSPAN="4" width="100" HEIGHT="5" align="center">'.  $res["Cantidad"].'</td>
                   <td COLSPAN="2" width="90" HEIGHT="5" align="center"> '.  $res["Proveedor"].'</td>
                           <td COLSPAN="2" width="90" HEIGHT="5" align="center">$ '.  $res["PrecioCompra"].'</td>
                        </tr>
                      ';
                   }
               $content .=
                    '</table>
               </div>';
            }
            else if( isset($_POST['PrecioVenta'] ))
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="12" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="100" HEIGHT="5" align="center">Codigo </td>
                             <td colspan="4" width="250" HEIGHT="5" align="center" >Nombre </td>
                             <td COLSPAN="2" width="100" HEIGHT="5" align="center" >Cantidad</td>
                             <td COLSPAN="4" width="150" HEIGHT="5" align="center" >Precio Venta</td>
                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
                '<tr>
                     <td COLSPAN="2" width="100" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                     <td colspan="4" width="250" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .' </td>
                     <td COLSPAN="2" width="100" HEIGHT="5" align="center" >'.  $res["Cantidad"]. '</td>
                     <td COLSPAN="4" width="150" HEIGHT="5" align="center" >$'.$res["PrecioVenta"] .'</td>
                 </tr>
               ';
                   }
               $content .=
                    '</table>
               </div>';
            }
            else if( isset($_POST['PrecioCompra'] ))
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="12" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="100" HEIGHT="5" align="center">Codigo </td>
                             <td colspan="4" width="250" HEIGHT="5" align="center" >Nombre </td>
                             <td COLSPAN="2" width="100" HEIGHT="5" align="center" >Cantidad</td>
                             <td COLSPAN="4" width="150" HEIGHT="5" align="center" >Precio Compra</td>
                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
                '<tr>
                     <td COLSPAN="2" width="100" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                     <td colspan="4" width="250" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .' </td>
                     <td COLSPAN="2" width="100" HEIGHT="5" align="center" >'.  $res["Cantidad"]. '</td>
                     <td COLSPAN="4" width="150" HEIGHT="5" align="center" >$'.$res["PrecioCompra"] .'</td>
                 </tr>
               ';
                   }
               $content .=
                    '</table>
               </div>';
            }
            else if( isset($_POST['Proveedor'] ))
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="12" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="100" HEIGHT="5" align="center">Codigo </td>
                             <td colspan="4" width="250" HEIGHT="5" align="center" >Nombre </td>
                             <td COLSPAN="2" width="100" HEIGHT="5" align="center" >Cantidad</td>
                             <td COLSPAN="4" width="150" HEIGHT="5" align="center" >Proovedor</td>
                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
                '<tr>
                     <td COLSPAN="2" width="100" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                     <td colspan="4" width="250" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .' </td>
                     <td COLSPAN="2" width="100" HEIGHT="5" align="center" >'.  $res["Cantidad"]. '</td>
                     <td COLSPAN="4" width="150" HEIGHT="5" align="center" >'.$res["Proveedor"] .'</td>
                 </tr>
               ';
                   }
               $content .=
                    '</table>
               </div>';
            }
            else
            {
              $content .=
                        '</table>
               <br>
                <table border="1" WIDTH="100" HEIGHT="100">
                         <tr>
                             <td colspan="16" HEIGHT="15" align="center" font >DESCRIPCION</td>
                         </tr>
                         <tr>
                             <td COLSPAN="2" width="50" HEIGHT="5" align="center">Codigo</td>
                             <td colspan="4" width="170" HEIGHT="5" align="center" >Nombre</td>
                             <td COLSPAN="2" width="50" HEIGHT="5" align="center" >Cant</td>
                             <td COLSPAN="2" width="75" HEIGHT="5" align="center" >Proveedor</td>
                             <td COLSPAN="2" width="75" HEIGHT="5" align="center" >Pre Venta</td>
                             <td COLSPAN="2" width="75" HEIGHT="5" align="center" >Pre Compra</td>
                             <td COLSPAN="2" width="75" HEIGHT="5" align="center" >Bodega</td>
                         </tr>
                         ';
               foreach( $showInventoryTranslateReport as $res)
                 {
                   $content .=
               '<tr>
                    <td COLSPAN="2" width="50" HEIGHT="5" align="center">'.  $res["Codigo"].'</td>
                    <td colspan="4" width="170" HEIGHT="5" align="center" >'.  $res["NombreArticulo"] .' </td>
                    <td COLSPAN="2" width="50" HEIGHT="5" align="center" >'.  $res["Cantidad"]. '</td>
                    <td COLSPAN="2" width="75" HEIGHT="5" align="center" >'.$res["Proveedor"] .'</td>
                    <td COLSPAN="2" width="75" HEIGHT="5" align="center" >$'. $res["PrecioVenta"] .'</td>
                    <td COLSPAN="2" width="75" HEIGHT="5" align="center" >$'.$res["PrecioCompra"] .'</td>
                    <td COLSPAN="2" width="75" HEIGHT="5" align="center" >'. $res["NombreBodega"] .'</td>
                </tr>
              ';
                }
             $content .=
                  '</table>
             </div>';
              }
		$pdf -> WriteHTML($content, true, 0, true, 0);
		$pdf -> Output('Generar_PDF.pdf');
        }
        catch (HTML2PDF_exception $e)
        {
            echo $e;
            exit;
        }
?>
