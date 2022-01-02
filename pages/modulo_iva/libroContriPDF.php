<?php
    require '../../vendor/autoload.php';
    use Spipu\Html2Pdf\Html2Pdf;

     //require("php/getDatos.php");

        // $tipoCuenta = $_POST[""];
        // $mes = $_POST[""];
        // $año = $_POST[""];

    //  $get = new getInfo();
    //  $Datos = $get->getBalanceComprobacion();

	try {
            ob_start();
              $pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(18, 15, 10, 10));
              $pdf->pdf->SetDisplayMode('fullpage');

           //Izquierda, Arriba, no se, abajo border-spacing: 15px;
            $content = '
            <div >
                <table  WIDTH="100" HEIGHT="100">
                  <tr>
                      <td  WIDTH="940"  align="center" style="font-size: 17px;"> <b> LIBRO O REGISTROS DE OPERACIONES DE VENTAS A CONTRIBUYENTES </b></td>
                  </tr>
                  </table>';


                        $content .=  '
                          <table  WIDTH="100" HEIGHT="100">
                              <tr>
                                <td colspan="3" width="555"  style="font-size: 12px;"><b>NOMBRE DEL CONTRIBUYENTE: </b> CABLE VISION POR SATELITE, SA DE CV</td>
                                <td  width="100" align="right" style="font-size: 12px;"><b>NRC.:</b></td>
                                <td  width="100" style="font-size: 12px;">110720-8</td>
                                <td  width="50" align="right" style="font-size: 12px;"><b>NIT:</b></td>
                                <td  width="110"   style="font-size: 12px;">06142408981086</td>
                              </tr>
                              <tr>
                              <td  style="font-size: 12px;"><b>MES:</b> Agosto</td>
                              <td   style="font-size: 12px;"><b>AÑO:</b> 2019</td>
                              <td  colspan="3" align="center" style="font-size: 12px;">VALORES EXPRESADOS EN US DOLARES</td>
                              <td  colspan="2" align="center" style="font-size: 12px;"><b>Folio No. 000001</b></td>
                              </tr>
                                   </table>
                                   ';


                                   $content .=  '
                                     <table  border="1" style="border-collapse:collapse;" WIDTH="100" HEIGHT="100">
                                         <tr>
                                         <td rowspan="3"  width="23"  align="center" style="font-size: 10px; vertical-align:bottom;">No.</td>
                                         <td rowspan="3"  width="50"   align="center" style="font-size: 10px; vertical-align:bottom;"> FECHA <br> DE  <br>  EMISION</td>
                                         <td rowspan="3" align="center" style="font-size: 10px; vertical-align:bottom;">N° <br> CORRELATIVO  <br> PREIMPRESO</td>
                                         <td rowspan="3" align="center" style="font-size: 10px;">N° DE <br> CONTROL <br>  INTERNO <br> SISTEMA  <br> FORMULARIO <br> UNICO</td>
                                         <td rowspan="3" WIDTH="268"  align="center" style="font-size: 10px; vertical-align:bottom;" >NOMBRE DE CLIENTE, MANDANTE O MANDATARIO</td>
                                         <td rowspan="3"  WIDTH="55" align="center" style="font-size: 10px; vertical-align:bottom;">NRC</td>

                                         <td colspan="7" align="center" style="font-size: 10px;">OPERACIONES DE VENTAS PROPIAS Y A CUENTA DE TERCEROS</td>
                                         <td rowspan="3" style="font-size: 10px; vertical-align:bottom;">TOTAL</td>
                                         </tr>
                                         <tr>
                                         <td colspan="3"  align="center" style="font-size: 10px;">PROPIAS</td>
                                         <td colspan="3"  align="center" style="font-size: 10px;">A CUENTA DE TERCEROS</td>
                                         <td rowspan="2" align="center" style="font-size: 10px;">IVA <BR> RETENIDO</td>
                                         </tr>
                                         <tr>
                                         <td align="center" style="font-size: 10px; vertical-align:bottom;">EXENTAS</td>
                                         <td align="center" style="font-size: 10px; vertical-align:bottom;">INTERNAS <br> GRAVADAS</td>
                                         <td align="center" style="font-size: 10px; vertical-align:bottom;">DEBITO  <br> FISCAL</td>
                                         <td align="center" style="font-size: 10px; vertical-align:bottom;">EXENTAS</td>
                                         <td align="center" style="font-size: 10px; vertical-align:bottom;">INTERNAS <br> GRAVADAS</td>
                                         <td align="center" style="font-size: 10px; vertical-align:bottom;">DEBITO  <br> FISCAL</td>
                                         </tr>
                                              </table><br>
                                              ';


                   $content .=  '
                     <table  WIDTH="100" HEIGHT="100">
                         <tr>
                         <td  WIDTH="40" style="font-size: 10px;">2589</td>
                         <td  width="50"  style="font-size: 10px;">01/08/2019</td>
                         <td  width="138"  align="center" style="font-size: 10px;">CF-0002379</td>
                         <td  width="260"  style="font-size: 10px;">TERESA DE JESUS MARAVILLA</td>
                         <td  width="45" style="font-size: 10px;">217917-0</td>
                         <td  width="40" style="font-size: 10px;">00.0</td>
                         <td  width="50" style="font-size: 10px;">500.00</td>
                         <td  width="35" style="font-size: 10px;">65.00</td>
                         <td  width="41" style="font-size: 10px;">0.00</td>
                         <td  width="51" style="font-size: 10px;">0.00</td>
                         <td  width="33" style="font-size: 10px;">0.00</td>
                         <td  width="45" style="font-size: 10px;">0.00</td>
                         <td  width="29" style="font-size: 10px;">565.00</td>
                         </tr>
<<<<<<< HEAD

=======
                      
>>>>>>> 457033a1198bd5e7928a056bbe9d803eea749e75
                         <tr>
                         <td  WIDTH="40" style="font-size: 10px;">2589</td>
                         <td  width="50"  style="font-size: 10px;">01/08/2019</td>
                         <td  width="138"  align="center" style="font-size: 10px;">CF-0002379</td>
                         <td  width="200"  style="font-size: 10px;">TERESA DE JESUS MARAVILLA</td>
                         <td  width="65" style="font-size: 10px;">217917-0</td>
                         <td  width="41" style="font-size: 10px;">00.0</td>
                         <td  width="51" style="font-size: 10px;">500.00</td>
                         <td  width="35" style="font-size: 10px;">65.00</td>
                         <td  width="41" style="font-size: 10px;">0.00</td>
                         <td  width="51" style="font-size: 10px;">0.00</td>
                         <td  width="33" style="font-size: 10px;">0.00</td>
                         <td  width="45" style="font-size: 10px;">0.00</td>
                         <td  width="29" style="font-size: 10px;">565.00</td>
                         </tr>

                              </table>
                              ';
             $content .=  '</div>';
        $pdf->setDefaultFont('times', 100);
		$pdf -> WriteHTML($content, true, 0, true, 0);

		$pdf -> Output('BalanceComprobacion.pdf');
        }
        catch (HTML2PDF_exception $e)
        {
            echo $e;
            exit;
        }
?>
