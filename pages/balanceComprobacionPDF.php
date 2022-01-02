<?php
    require '../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;

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
